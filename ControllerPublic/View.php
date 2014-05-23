<?php

class AssociationMc_ControllerPublic_View extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        return $this->actionView();
    }

    public function actionView() {
        $visitor = XenForo_Visitor::getInstance();
        if (!$visitor->getUserId()) {
            return $this->responseNoPermission();
        }

        $model = $this->getAssociationEntryModel();
        $entry = $model->getEntryById($visitor->getUserId());

        if ($entry != null) {
            return $this->actionManage($visitor, $entry);
        }


        $mcassoc = $this->getMcAssoc();

        $paths = XenForo_Application::get('requestPaths');
        $paths = XenForo_Application::get('requestPaths');

        $user = $visitor['username'];
        $return_link = $this->getConfirmUrl($user);

        $key = $mcassoc->generateKey($user);
        $find = $this->_input->filterSingle('stage', XenForo_Input::UNUM);

        return $this->responseView('AssociationMc_ViewPublic_View', 'association_view', array(
            "siteId" => $mcassoc->getSiteId(),
            "key" => $key,
            "stage" => $find,
            "retLink" => $return_link,
            "associated" => false));
    }

    private function getConfirmUrl($username) {
        $link = XenForo_Link::buildPublicLink("full:mc-association/confirm", null, array(
            'stage' => '3',
            'username' => $username
        ));
        return $link;
    }

    private function getMcAssoc() {
        $opts = XenForo_Application::get('options');
        return new AssociationMc_MCAssoc($opts->mcAssocSiteId, $opts->mcAssocInstanceSecret, $opts->mcAssocSharedSecret);
    }



    /**
     * Get our model.
     *
     * @return AssociationMc_Model_AssociationEntry
     */
    private function getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

    private function actionManage($visitor, $entry) {
        return $this->responseView('AssociationMc_ViewPublic_View', 'association_view', array(
            "associated" => true,
            "deleteUrl" => XenForo_Link::buildPublicLink("full:mc-association/delete"),
            "model" => $entry));
    }
} 