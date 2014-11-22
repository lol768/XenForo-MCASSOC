<?php

class AssociationMc_Listener_LoadAdminUserEditController {

    public static function hook($class, array &$extend) {
        $extend[] = 'AssociationMc_ControllerAdmin_User';
    }

}