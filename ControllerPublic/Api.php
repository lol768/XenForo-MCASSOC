<?php

/**
 * Class AssociationMc_ControllerPublic_Thread
 * @@see XenForo_ControllerPublic_Thread
 */
class AssociationMc_ControllerPublic_Api extends XenForo_ControllerPublic_Abstract {

    public function _preDispatch($action) {
        parent::_preDispatch($action);
        $this->_routeMatch->setResponseType('json');
        $opts = XenForo_Application::get('options');
        if (!$opts->mcAssocApiEnable) {
            throw $this->getNoPermissionResponseException();
        } else {
            $token = $this->_input->filterSingle('token', XenForo_Input::STRING);
            if ($token != $opts->mcAssocApiToken) {
                throw $this->getNoPermissionResponseException();
            }
        }
    }

    public function actionLookupUserById() {
        $userId = $this->_input->filterSingle('uid', XenForo_Input::UINT);

        $entry = $this->_getAssociationEntryModel()->getEntryById($userId);
        if (!$entry) {
            $entry = [];
        } else {
            if (array_key_exists("minecraft_uuid", $entry)) {
                $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
            }
            $this->handleAdditionalInfo($entry);
        }
        return $this->responseView('AssociationMc_ViewPublic_Api', '', array("data" => $entry));
    }

    public function actionLookupXenforoUser() {
        $username = $this->_input->filterSingle('username', XenForo_Input::STRING);

        $user = $this->_getUserModel()->getUserByName($username);
        if (!$user) {
            $data = array("data" => []);
        } else {
            $data = array("data" => $user);
        }
        return $this->responseView('AssociationMc_ViewPublic_Api', '', $data);
    }

    public function actionLookupUserByUuid() {
        $uuid = $this->_input->filterSingle('uuid', XenForo_Input::STRING);

        $entry = $this->_getAssociationEntryModel()->getEntryByMinecraftUuid($uuid);
        if (!$entry) {
            $entry = [];
        } else {
            if (array_key_exists("minecraft_uuid", $entry)) {
                $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
            }
            $this->handleAdditionalInfo($entry);
        }
        return $this->responseView('AssociationMc_ViewPublic_Api', '', array("data" => $entry));
    }

    public function addUserToGroup() {

    }

    private function handleAdditionalInfo(&$entry) {
        $addInfo = $this->_input->filterSingle('userInfo', XenForo_Input::BOOLEAN);
        if ($addInfo) {
            $entry['user'] = $this->_getUserModel()->getUserById($entry['xenforo_id']);
        }
        $entry['last_mc_username'] = $entry['last_username'];
        unset($entry['last_username']);


    }

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

}