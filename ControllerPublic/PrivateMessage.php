<?php

/**
 * Class AssociationMc_ControllerPublic_PrivateMessage
 * @@see XenForo_ControllerPublic_Conversation
 */
//class AssociationMc_ControllerPublic_PrivateMessage extends XenForo_ControllerPublic_Conversation {
class AssociationMc_ControllerPublic_PrivateMessage extends XFCP_AssociationMc_ControllerPublic_PrivateMessage {

    public function actionView() {
        $view = parent::actionView();
        if (!$view instanceof XenForo_ControllerResponse_View) {
            return $view;
        }
        $uniqueUserIds = $this->getUniqueUserIds($view->params['messages']);
        $model = $this->_getAssociationEntryModel();
        $entries = $model->getEntriesByUserIds($uniqueUserIds, true);
        $names = [];
        foreach ($entries as $entry) {
            $names[$entry['xenforo_id']] = $entry['last_username'];
        }
        $view->params['mcNames'] = $names;
        return $view;
    }

    private function getUniqueUserIds(array $messages) {
        $ids = [];
        foreach ($messages as $postId => $post) {
            if (!in_array($post['user_id'], $ids)) {
                $ids[] = $post['user_id'];
            }
        }
        return $ids;
    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

} 