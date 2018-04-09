<?php

/**
 * Class AssociationMc_ControllerPublic_Thread
 * @@see XenForo_ControllerPublic_Thread
 */
class AssociationMc_ControllerPublic_Api extends XenForo_ControllerPublic_Abstract {

    private $userCache = [];

    public function _preDispatch($action) {
        parent::_preDispatch($action);
        $this->_routeMatch->setResponseType('json');
	if (!$_SERVER['HTTP_USER_AGENT']) {
		throw new XenForo_Exception('User-Agent Required', true);
	}
        $opts = XenForo_Application::get('options');
        if (!$opts->mcAssocApiEnable) {
            throw new XenForo_Exception('API Temporarily Unavailable', true);
        } else {
            $token = $this->_input->filterSingle('token', XenForo_Input::STRING);
	    if ($token !== $opts->mcAssocApiToken) {
                throw new XenForo_Exception('Invalid Token', true);
            }
        }
    }

    public function actionLookupUserById() {
        $userId = $this->_input->filterSingle('uid', XenForo_Input::UINT);

        $entries = $this->_getAssociationEntryModel()->getEntriesByUserId($userId);
        if (!$entries) {
            $entries = [];
        } else {
            foreach ($entries as &$entry) {
                if (array_key_exists("minecraft_uuid", $entry)) {
                    $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
                }
                $this->handleAdditionalInfo($entry);
            }

        }
        return $this->responseView('AssociationMc_ViewPublic_Api', '', array("data" => $entries));
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

    public function actionListAll() {
        $addInfo = $this->_input->filterSingle('userInfo', XenForo_Input::BOOLEAN);
        $entries = $this->_getAssociationEntryModel()->getAll();
        $ids = [];
        foreach ($entries as $entry) {
            $ids[] = $entry['xenforo_id'];
        }
        $users = $this->_getUserModel()->getUsersByIds($ids);
        foreach ($entries as &$entry) {
            $entry['username'] = $users[$entry['xenforo_id']]['username'];

            if ($addInfo) {
                $entry['userInfo'] = $users[$entry['xenforo_id']];
            }
        }
        return $this->responseView('AssociationMc_ViewPublic_Api', '', array("data" => $entries));
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
            if (array_key_exists($entry['xenforo_id'], $this->userCache)) {
                $entry['user'] = $this->userCache[$entry['xenforo_id']];
            } else {
                $entry['user'] = $this->_getUserModel()->getUserById($entry['xenforo_id']);
            }
            $this->userCache[$entry['xenforo_id']] = $entry['user'];
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
