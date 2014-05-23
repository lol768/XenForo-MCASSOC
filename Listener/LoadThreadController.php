<?php

class AssociationMc_Listener_LoadThreadController {

    public static function hook($class, array &$extend) {
        $extend[] = 'AssociationMc_ControllerPublic_Thread';
    }

} 