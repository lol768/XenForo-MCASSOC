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
        ec("Error > Request to API Failed; Retrying in 5 Seconds" . $http_response_header[0]);
        sleep(5);
        return grabLatestIgn($uuid);
    }
    return $contents[(count($contents) - 1)]->name;
}

if (php_sapi_name() !== "cli") {
    die("Error > Please Run Through Command Line");
}

$libDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
$xfPath = $libDir . "XenForo" . DIRECTORY_SEPARATOR;
$autoloaderPath = $xfPath . DIRECTORY_SEPARATOR . "Autoloader.php";
if (!file_exists($autoloaderPath)) {
    ec("Checked " . $libDir . DIRECTORY_SEPARATOR . "Autoloader.php");
    die("Error > Script Must Reside Within AssociationMc Library Folder");
}

/** @noinspection PhpIncludeInspection */
require_once($autoloaderPath);
XenForo_Autoloader::getInstance()->setupAutoloader($libDir);
XenForo_Application::initialize($libDir, $libDir);
XenForo_Application::setDebugMode(true);
$dependencies = new XenForo_Dependencies_Public();
$dependencies->preLoadData();

$db = XenForo_Application::getDb();

$records = $db->fetchAll('SELECT *, HEX(minecraft_uuid) FROM xf_association_mc');
$totalRecords = count($records);
ec("Username Update > $totalRecords Entries Pending Processing" . PHP_EOL);
$i = 0;
foreach ($records as $record) {
    $hex = $record['HEX(minecraft_uuid)'];
    $xfId = $record['xenforo_id'];
    $lastUsername = $record['last_username'];
    ec("Username Update > Processing XenForo user ID $xfId. Their last known username was $lastUsername. Their UUID is $hex.");
    ec("Username Update > Requesting Username From Mojang...");
    $latestName = grabLatestIgn($hex);
    if ($latestName === $lastUsername) {
        ec("Username Update > No Changes Found; Ignoring");
    } else {
        ec("Username Update > $hex is now known as $latestName. Updating database...");
        $newData = array("last_username" => $latestName);
        $db->update("xf_association_mc", $newData, array("minecraft_uuid = ?" => $record['minecraft_uuid']));
        ec("Username Update > Database Updated");
    }
    $i++;
    ec("Username Update > Waiting 1 Second For Rate Limit Avoidance");
    sleep(1);

    ec(PHP_EOL . ($totalRecords - $i) . " remaining queued updates. " . (float)($i / $totalRecords)*100 . "% Complete" . PHP_EOL);
}

ec("Username Update Completed");
