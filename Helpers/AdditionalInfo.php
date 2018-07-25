<?php

class AssociationMc_Helpers_AdditionalInfo {

    public static function helperGetAdditionalInfoUrl($url, $username="", $uuid="") {
        $opts = XenForo_Application::get('options');
        $url = str_replace(["%name", "%uuid"], [$username, $uuid], $url);
        return htmlentities($url);
    }

}
