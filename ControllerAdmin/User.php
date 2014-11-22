<?php

/**
 * Class AssociationMc_ControllerAdmin_User
 * @@see XenForo_ControllerAdmin_User
 */
class AssociationMc_ControllerAdmin_User extends XFCP_AssociationMc_ControllerAdmin_User {
    public function actionExtra() {
        $view = parent::actionExtra();
        $userId = $view->params['user']['user_id'];
        $model = $this->_getAssociationEntryModel();
        $entry = $this->getDataForEntry($model->getEntryById($userId));
        $params = $view->params;
        $params['mcAssoc'] = $entry;
        $view->params = $params;
        return $view;
    }

    private function getDataForEntry($entry) {
        if ($entry !== false) {
            $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
            $entry['associated'] = true;
            return $entry;
        }
        return ["associated" => false];
    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

}