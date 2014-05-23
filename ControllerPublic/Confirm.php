<?php

class AssociationMc_ControllerPublic_Confirm extends XenForo_ControllerPublic_Abstract {

    public function _checkCsrf($action) {
        return;
    }

    public function actionConfirm() {

        $mcAssoc = $this->getMcAssoc();
        $inputData = $this->_input->filterSingle('data', XenForo_Input::STRING);
        $isAdmin = XenForo_Visitor::getInstance()['is_admin'];
        try {
            $data = $mcAssoc->unwrapData($inputData);
            $username = $mcAssoc->unwrapKey($data->key);
            die(json_encode($data));
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

    private function getMcAssoc() {
        $opts = XenForo_Application::get('options');
        return new AssociationMc_MCAssoc($opts->mcAssocSiteId, $opts->mcAssocInstanceSecret, $opts->mcAssocInstanceSecret);
    }

} 