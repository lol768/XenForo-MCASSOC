<?php

class AssociationMc_Listener_MemberPageTabContent {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {

        /** @var AssociationMc_Model_AssociationEntry $model */
        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        $entries = $model->getEntryCountForUserId($hookParams['user']['user_id']);
        if ($entries > 0) {
            $myTemplate = new XenForo_Template_Public("association_profile_tab_content", $hookParams);
            $myTemplate->setParam("mcEntries", $model->getEntriesByUserId($hookParams['user']['user_id']));
            $myTemplate->setParam("insecure", XenForo_Application::getOptions()->mcAssocInsecure);
            $contents .= $myTemplate->render();
        }
    }
} 
