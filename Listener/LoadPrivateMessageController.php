<?php

class AssociationMc_Listener_LoadPrivateMessageController {

    public static function hook($class, array &$extend) {
        $extend[] = 'AssociationMc_ControllerPublic_PrivateMessage';
    }

} 