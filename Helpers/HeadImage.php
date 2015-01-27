<?php

class AssociationMc_Helpers_HeadImage {

    public static function helperGetHeadImageUrl($username, $size, $img=false) {
        $opts = XenForo_Application::get('options');
        $url = $opts->mcAssocAvatarUrl;
        $url = str_replace(["%u", "%s"], [$username, $size], $url);
        return ($img) ? "<img src=\"" . $url . "\" width=$size height=$size>" : strip_tags($url);
    }

}