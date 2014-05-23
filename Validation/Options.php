<?php

class AssociationMc_Validation_Options {

    public static function validateSecret($value, XenForo_DataWriter $dw, $fieldName) {
        if (strlen($value) % 2 != 0 || !ctype_xdigit($value)) {
            $dw->error(new XenForo_Phrase("mc_assoc_errors_hex_string"), $fieldName);
        }
        return $dw;
    }


} 