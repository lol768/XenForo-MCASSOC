<?php

class AssociationMc_ControllerPublic_View extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        return $this->actionView();
    }


    public function actionView() {
        $mcassoc = $this->getMcAssoc();
        $visitor = XenForo_Visitor::getInstance();
        $paths = XenForo_Application::get('requestPaths');
        $paths = XenForo_Application::get('requestPaths');

        $user = $visitor['username'];
        $return_link = $this->getConfirmUrl($paths['fullUri'], $user);

        $key = $mcassoc->generateKey($user);
        $find = $this->_input->filterSingle('stage', XenForo_Input::UNUM);

        return $this->responseView('AssociationMc_ViewPublic_View', 'association_view', array(
            "siteId" => $mcassoc->getSiteId(),
            "key" => $key,
            "stage" => $find,
            "retLink" => $return_link,
            "signedIn" => ($visitor->getUserId() != null)));
    }

    private function getConfirmUrl($currentUrl, $username) {
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
} 