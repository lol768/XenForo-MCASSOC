<?php

class AssociationMc_ViewPublic_Api extends XenForo_ViewPublic_Base {

    public function renderJson() {
        return $this->_params['data'];
    }

} 