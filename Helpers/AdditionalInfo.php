<?php

class AssociationMc_Helpers_AdditionalInfo {

    public static function helperGetAdditionalInfoUrl($username="", $uuid="") {
        $opts = XenForo_Application::get('options');
        $url = $opts->mcAssocAddInfo['url'];
        $url = str_replace(["%name", "%uuid"], [$username, $uuid], $url);
        return htmlentities($url);
    }

}
