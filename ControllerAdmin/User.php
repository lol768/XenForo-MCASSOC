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
        $entries = $this->getDataForEntries($model->getEntriesByUserId($userId));
        $params = $view->params;
        $params['mcAssoc'] = $entries;
        $params['mcAssocAssociated'] = count($entries) != 0;
        $view->params = $params;

        return $view;
    }

    private function getDataForEntries($entries) {
        if (count($entries) !== 0) {
            foreach ($entries as &$entry) {
                $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
                $entry['associated'] = true;
            }
            return $entries;
        }
        return [];
    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

}
