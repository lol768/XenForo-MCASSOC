<?php
class AssociationMc_Listener_ThreadPost {
    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Public("association_thread_post", $hookParams);
        $myTemplate->setParam("addInfo", XenForo_Application::getOptions()->mcAssocAddInfo);
        $contents .= $myTemplate->render();
    }
}
