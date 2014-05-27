<?php

/**
 * Class AssociationMc_ControllerPublic_Delete
 */
class AssociationMc_ControllerPublic_Delete extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        $visitorId = XenForo_Visitor::getUserId();
        $associationDw = XenForo_DataWriter::create('AssociationMc_DataWriter_AssociationEntry');
        $associationDw->setExistingData($visitorId);
        $associationDw->delete();
        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS, XenForo_Link::buildPublicLink("mc-association/view"));
    }
} 