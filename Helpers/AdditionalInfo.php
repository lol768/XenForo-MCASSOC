<?php

class AssociationMc_Helpers_AdditionalInfo {

    public static function helperGetAdditionalInfoUrl($username=NULL, $uuid=NULL) {
        $opts = XenForo_Application::get('options');
        $url = $opts->mcAssocAddInfoUrl;
        $url = str_replace(["%name", "%uuid"], [$username, $uuid], $url);
        return "<a href=\"" . $url . "\" target=\"_blank\">";
    }

}
