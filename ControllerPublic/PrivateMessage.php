<?php

/**
 * Class AssociationMc_ControllerPublic_PrivateMessage
 * @@see XenForo_ControllerPublic_Conversation
 */
//class AssociationMc_ControllerPublic_PrivateMessage extends XenForo_ControllerPublic_Conversation {
class AssociationMc_ControllerPublic_PrivateMessage extends XFCP_AssociationMc_ControllerPublic_PrivateMessage {

    /**
     * Handles viewing a conversation page.
     * @return mixed
     */
    public function actionView() {
        $view = parent::actionView();
        return $this->transformView($view);
    }

    /**
     * Gets all the unique user IDs for a bunch of messages.
     * @param array $messages The messages to scan.
     * @return int[] User id array.
     */
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

    /**
     * Handles the AJAX replies.
     * @return mixed
     */
    public function actionInsertReply() {
        $view = parent::actionInsertReply();
        return $this->transformView($view);
    }

    /**
     * @param XenForo_ControllerResponse_Abstract $view
     * @return mixed The modified view.
     */
    private function transformView($view) {
        if (!$view instanceof XenForo_ControllerResponse_View) {
            return $view;
        }
        $uniqueUserIds = $this->getUniqueUserIds($view->params['messages']);
        $model = $this->_getAssociationEntryModel();
        $entries = $model->getEntriesByUserIds($uniqueUserIds, true);
        $names = [];
        $maxCount = XenForo_Application::get('options')->maxAccountsDisplaySidebar;
        foreach ($entries as $entry) {
            if (!array_key_exists($entry['xenforo_id'], $names)) {
                $names[$entry['xenforo_id']] = [];
            }
            // could SELECT instead
            if (!$entry['display_by_posts'] || count($names[$entry['xenforo_id']]) >= $maxCount) {
                continue;
            }
            $names[$entry['xenforo_id']] = $names[$entry['xenforo_id']] + [$entry['last_username']];
        }
        $view->params['mcNames'] = $names;
        return $view;
    }

} 
