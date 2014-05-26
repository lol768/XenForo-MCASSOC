<?php

/**
 * Class AssociationMc_ControllerPublic_Confirm
 */
class AssociationMc_ControllerPublic_Confirm extends XenForo_ControllerPublic_Abstract {

    /**
     * We override the CSRF checking here because everything is validated
     * in our actionConfirm block.
     *
     * @param string $action
     */
    public function _checkCsrf($action) {
        return;
    }

    /**
     * Check and apply the association request.
     *
     * @return XenForo_ControllerResponse_Redirect|XenForo_ControllerResponse_View
     */
    public function actionConfirm() {

        $mcAssoc = $this->getMcAssoc();

        $inputData = $this->_input->filterSingle('data', XenForo_Input::STRING);
        $visitor = XenForo_Visitor::getInstance();
        $isAdmin = $visitor['is_admin'];
        $visitorName = $visitor['username'];
        try {
            $data = $mcAssoc->unwrapData($inputData);
            $username = $mcAssoc->unwrapKey($data->key);
            if ($username != $visitorName) {
                throw new Exception("Username does not match.");
            }
            $this->handleData($visitor, $data);
            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink("mc-association/view"));
        } catch (Exception $e) {
            if ($inputData == null) {
                $message = "No data provided.";
            } else {
                $message = $e->getMessage();
            }
            $opts = XenForo_Application::get('options');
            $message .="<br /><pre>Credentials in use" . json_encode(["site_id" => $opts->mcAssocSiteId, "instance_secret" => $opts->mcAssocInstanceSecret, "shared_secret" => $opts->mcAssocSharedSecret]) . "</pre>";
            return $this->responseView('AssociationMc_ViewPublic_Error', 'association_error', array("exceptionMessage" => ($isAdmin) ? $message : "Please contact an administrator for more information."));
        }

    }

    /**
     * Do the data writing.
     *
     * @param XenForo_Visitor $visitor The visitor object.
     * @param StdClass $data Data from MCAssoc service.
     */
    private function handleData(XenForo_Visitor $visitor, $data) {

        $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
        $associationDw->set('xenforo_id', $visitor->getUserId());
        $associationDw->set('minecraft_uuid', hex2bin($data->uuid));
        $associationDw->set('last_username', $data->username);
        $associationDw->save();

    }

    /**
     * @return AssociationMc_MCAssoc The MCAssoc object.
     */
    private function getMcAssoc() {
        $opts = XenForo_Application::get('options');
        $mc = new AssociationMc_MCAssoc($opts->mcAssocSiteId, $opts->mcAssocSharedSecret, $opts->mcAssocInstanceSecret);
        if ($opts->mcAssocInsecure) {
            $mc->enableInsecureMode();
        }
        return $mc;
    }

} 