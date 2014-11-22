<?php

/**
 * Class AssociationMc_ControllerPublic_Delete
 */
class AssociationMc_ControllerPublic_Delete extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        $visitorId = XenForo_Visitor::getUserId();
        $this->checkExists($visitorId);
        $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
        $associationDw->setExistingData($visitorId);
        $associationDw->delete();
        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink("mc-association/view"));
    }

    public function actionDeleteOther() {
        $userId = $this->_input->filterSingle("user_id", XenForo_Input::UINT);
        $this->checkExists($userId);
        $visitor = XenForo_Visitor::getInstance();
        $hasPermission = $visitor->hasPermission("mcAssoc", "mcAssocRemoveFromAny");
        if (!$hasPermission) {
            throw $this->getNoPermissionResponseException();
        } else {
            $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
            $associationDw->setExistingData($userId);
            $associationDw->delete();
            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildAdminLink("users/list"));
        }

    }

    /**
     * Get our model.
     *
     * @return AssociationMc_Model_AssociationEntry
     */
    private function getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

    private function checkExists($visitorId) {
        $model = $this->getAssociationEntryModel();
        if ($model->getEntryById($visitorId) === false) {
            die("No entry exists for this user.");
        }
    }

} 