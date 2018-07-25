<?php

class AssociationMc_Listener_MemberPageTabContent {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {

        /** @var AssociationMc_Model_AssociationEntry $model */
        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        $entries = $model->getEntryCountForUserId($hookParams['user']['user_id']);
        if ($entries > 0) {
            $myTemplate = new XenForo_Template_Public("association_profile_tab_content", $hookParams);
            $opts = XenForo_Application::getOptions();
            $entries = $model->getEntriesByUserId($hookParams['user']['user_id']);
            AssociationMc_Utility_BinaryTransformation::convertEntriesToHumanReadableUuids($entries);
            $myTemplate->setParam("mcEntries", $entries);
            $myTemplate->setParam("insecure", $opts->mcAssocInsecure);
            $myTemplate->setParam("addInfo", $opts->mcAssocAddInfo);
            $contents .= $myTemplate->render();
        }
    }
} 
