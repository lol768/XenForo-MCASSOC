<?php

/**
 * Class AssociationMc_ControllerPublic_Delete
 */
class AssociationMc_ControllerPublic_Delete extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        $visitorId = XenForo_Visitor::getUserId();
        $uuid = $this->_input->filterSingle("uuid", XenForo_Input::STRING);
        $model = $this->checkExists($uuid, $visitorId);

        $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
        $associationDw->setExistingData($model);
        $associationDw->delete();
        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink("mc-association/view"));
    }

    public function actionDeleteOther() {
        $userId = $this->_input->filterSingle("user_id", XenForo_Input::UINT);
        $uuid = $this->_input->filterSingle("uuid", XenForo_Input::STRING);
        $model = $this->checkExists($uuid, $userId);
        $visitor = XenForo_Visitor::getInstance();
        $hasPermission = $visitor->hasPermission("mcAssoc", "mcAssocRemoveFromAny") || $visitor->hasAdminPermission("user");
        if (!$hasPermission) {
            throw $this->getNoPermissionResponseException();
        } else {
            $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
            $associationDw->setExistingData($model);
            $associationDw->delete();
            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildAdminLink("users/edit", ['user_id' => $userId]));
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

    private function checkExists($uuid, $visitorId) {
        $model = $this->getAssociationEntryModel();
        $retVal = $model->getEntryByMinecraftUuidAndUserId(hex2bin($uuid), $visitorId);
        if ($retVal === false) {
            die("No entry exists for this user.");
        }
        return $retVal;
    }

} 
