<?php
class AssociationMc_Listener_NewUserCriteria {

    public static function hook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template) {
        $myTemplate = new XenForo_Template_Admin("association_custom_criteria");
        $contents .= $myTemplate->render();
    }

    public static function checkCriteria($rule, array $data, array $user, &$returnValue) {
        switch($rule) {
            case "mc_assoc_associated":
                $returnValue = self::checkAssociationStatus($user);
                break;
        }
    }

    private static function checkAssociationStatus(array $user) {
        $model = XenForo_Model::create("AssociationMc_Model_AssociationEntry");
        /** @var AssociationMc_Model_AssociationEntry $model */
        return ($model->getEntryCountForUserId($user['user_id']) > 0);
    }
}