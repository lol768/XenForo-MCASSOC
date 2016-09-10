<?php

class AssociationMc_Listener_UserDeleteDataWriter {

    public static function hook($class, array &$extend) {
        $extend[] = 'AssociationMc_DataWriter_User';
    }

} 