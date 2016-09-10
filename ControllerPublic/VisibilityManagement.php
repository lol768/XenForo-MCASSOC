<?php

/**
 * Class AssociationMc_ControllerPublic_VisibilityManagement
 */
class AssociationMc_ControllerPublic_VisibilityManagement extends XenForo_ControllerPublic_Abstract {

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

    /**
     * @return XenForo_Model_User
     */
    private function _getUserModel() {
        return $this->getModelFromCache('XenForo_Model_User');
    }

    /**
     * @return XenForo_ControllerResponse_Error
     * @throws XenForo_Exception
     */
    public function actionIndex() {
        $id = $this->_input->filterSingle("association_id", XenForo_Input::UINT);
        $display = $this->_input->filterSingle("display_by_posts", XenForo_Input::STRING);
        $item = $this->_getAssociationEntryModel()->getEntryByAssociationId($id);
        if (!$item || $item['xenforo_id'] != XenForo_Visitor::getUserId()) {
            return $this->getNotFoundResponse();
        }
        $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
        $associationDw->setExistingData($item);
        $display = $display == "true";
        $threshold = XenForo_Application::get('options')->maxAccountsDisplaySidebar;
        if ($this->_getAssociationEntryModel()->getEntryCountForUserId(XenForo_Visitor::getUserId(), true) >= $threshold) {
            $associationDw->set("display_by_posts", 0);
        }
        $associationDw->set("display_by_posts", $display);
        $associationDw->save();
        return $this->responseView('AssociationMc_ViewPublic_Api', '', array("data" => json_encode(["displaying" => $display])));

    }

}
