<?php

/**
 * Class AssociationMc_DataWriter_User
 * @see XenForo_DataWriter_User
 */
class AssociationMc_DataWriter_User extends XFCP_AssociationMc_DataWriter_User {

    /**
     * Disassociates users before they are deleted.
     * @see XenForo_DataWriter_User::_preDelete()
     * @throws XenForo_Exception
     */
    protected function _preDelete() {
        parent::_preDelete();
        if ($this->hasErrors()) {
            return;
        }

        /**
         * @var $assocModel AssociationMc_Model_AssociationEntry
         */
        $assocModel = $this->getModelFromCache("AssociationMc_Model_AssociationEntry");
        $userId = $this->get("user_id");
        $count = $assocModel->getEntryCountForUserId($userId);
        if ($count >= 1) {
            $assocModel->deleteEntriesByUserIdEfficiently($userId);
        }
    }
}
