<?php
class AssociationMc_Listener_VisitorDropdown {

    public static function hookLeft($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Public("association_visitor_left", $hookParams);
        $contents .= $myTemplate->render();
    }
    public static function hookRight($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Public("association_visitor_right", $hookParams);
        $contents .= $myTemplate->render();
    }
}