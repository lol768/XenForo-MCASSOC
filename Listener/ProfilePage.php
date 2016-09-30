<?php

class AssociationMc_Listener_ProfilePage {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {

        /** @var AssociationMc_Model_AssociationEntry $model */
        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        $entries = $model->getEntriesByUserId($hookParams['user']['user_id'], true);
        if (count($entries) > 0) {
            foreach ($entries as &$entry) {
                $entry["title"] = "";
            }
            $entries[0]["title"] = "Minecraft:";
            AssociationMc_Utility_BinaryTransformation::convertEntriesToHumanReadableUuids($entries);
            $myTemplate = new XenForo_Template_Public("association_profile_sidebar", array(
                "mcEntries" => $entries
            ));
            $contents .= $myTemplate->render();
        }

    }



} 
