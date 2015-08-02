<?php

// Note: PunKeel has written another script which makes use of an unofficial API with much more generous
// rate limiting. PunKeel's script also splits the data into chunks and processes them in separate processes.
// See https://gist.github.com/PunKeel/9db6232f900899437b17 if this sounds useful.

function ec($msg) {
    echo $msg . PHP_EOL;
}

function grabLatestIgn($uuid) {
    $url = "https://api.mojang.com/user/profiles/" . $uuid . "/names";
    $contents = json_decode(file_get_contents($url));
    if (strpos($http_response_header[0], "200") === false) {
        ec("Oops, this request failed. I'm going to wait 5 seconds and try again! " . $http_response_header[0]);
        sleep(5);
        return grabLatestIgn($uuid);
    }
    return $contents[(count($contents) - 1)]->name;
}

if (php_sapi_name() !== "cli") {
    die("Oops. Please run this script at the command line");
}

$libDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
$xfPath = $libDir . "XenForo" . DIRECTORY_SEPARATOR;
$autoloaderPath = $xfPath . DIRECTORY_SEPARATOR . "Autoloader.php";
if (!file_exists($autoloaderPath)) {
    ec("Checked " . $libDir . DIRECTORY_SEPARATOR . "Autoloader.php");
    die("This file should be inside the AssociationMc directory in the library directory of a XenForo installation.");
}

/** @noinspection PhpIncludeInspection */
require_once($autoloaderPath);
XenForo_Autoloader::getInstance()->setupAutoloader($libDir);
XenForo_Application::initialize($libDir, $libDir);
XenForo_Application::setDebugMode(true);
$dependencies = new XenForo_Dependencies_Public();
$dependencies->preLoadData();

$db = XenForo_Application::getDb();
/** @var $db Zend_Db_Adapter_Abstract */

// Fun hack so we don't need a new function on the model :P

$records = $db->fetchAll('SELECT *, HEX(minecraft_uuid) FROM xf_association_mc');
$totalRecords = count($records);
ec("$totalRecords recoord(s) are to be processed." . PHP_EOL);
$i = 0;
foreach ($records as $record) {
    $hex = $record['HEX(minecraft_uuid)'];
    $xfId = $record['xenforo_id'];
    $lastUsername = $record['last_username'];
    ec("Processing user with id $xfId. Their last known username was $lastUsername. Their UUID is $hex.");
    ec("Requesting names info from Mojang...");
    $latestName = grabLatestIgn($hex);
    if ($latestName === $lastUsername) {
        ec("No changes for this user, leaving them be.");
    } else {
        ec("$hex is now known as $latestName. Updating database...");
        $newData = array("last_username" => $latestName);
        $db->update("xf_association_mc", $newData, array("xenforo_id = ?" => $xfId));
        ec("Database has been updated.");
    }
    $i++;
    ec("Sleeping to avoid rate limit...");
    sleep(1);

    ec(PHP_EOL . ($totalRecords - $i) . " records remain. We're " . (float)($i / $totalRecords)*100 . "% done." . PHP_EOL);
}

ec("All done.");
