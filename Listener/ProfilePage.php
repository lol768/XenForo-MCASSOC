<?php

class AssociationMc_Listener_ProfilePage {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {

        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        $entry = $model->getEntryById($hookParams['user']['user_id']);
        if ($entry != null) {
            $myTemplate = new XenForo_Template_Public("association_profile_sidebar", array(
                "mcName" => $entry['last_username']
            ));
            $contents .= $myTemplate->render();
        }

    }



} 