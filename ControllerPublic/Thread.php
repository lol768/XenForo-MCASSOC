<?php

/**
 * Class AssociationMc_ControllerPublic_Thread
 * @@see XenForo_ControllerPublic_Thread
 */
//class AssociationMc_ControllerPublic_Thread extends XenForo_ControllerPublic_Thread {
class AssociationMc_ControllerPublic_Thread extends XFCP_AssociationMc_ControllerPublic_Thread {

    /**
     * Used when just viewing a thread.
     * @return mixed
     */
    public function actionIndex() {
        $view = parent::actionIndex();
        return $this->transformView($view);

    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

    /**
     * Used when displaying posts after submitting a new rpely.
     * @return mixed
     */
    public function actionAddReply() {
        $view = parent::actionAddReply();
        return $this->transformView($view);
    }

    /**
     * @param XenForo_ControllerResponse_Abstract $view
     * @return mixed The modified view.
     */
    private function transformView($view) {
        $uniqueUserIds = [];
        if (!$view instanceof XenForo_ControllerResponse_View) {
            return $view;
        }
        foreach ($view->params['posts'] as $post) {
            if (!in_array($post['user_id'], $uniqueUserIds)) {
                $uniqueUserIds[] = $post['user_id'];
            }
        }
        $model = $this->_getAssociationEntryModel();
        $entries = $model->getEntriesByUserIds($uniqueUserIds, true);
        $names = [];
        foreach ($entries as $entry) {
            $names[$entry['xenforo_id']] = $entry['last_username'];
        }
        $view->params['mcNames'] = $names;
        return $view;
    }

} 
