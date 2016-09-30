<?php

class AssociationMc_Listener_MemberPageTabs {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {

        /** @var AssociationMc_Model_AssociationEntry $model */
        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        $entryCount = $model->getEntryCountForUserId($hookParams['user']['user_id']);
        if ($entryCount > 0) {
            $myTemplate = new XenForo_Template_Public("association_profile_tab", ["count" => $entryCount]);
            $contents .= $myTemplate->render();
        }
    }
} 
