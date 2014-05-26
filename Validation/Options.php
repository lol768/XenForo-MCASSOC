<?php

class AssociationMc_Validation_Options {

    public static function validateSecret($value, XenForo_DataWriter $dw, $fieldName) {
        if (strlen($value) % 2 != 0 || !ctype_xdigit($value)) {
            $dw->error(new XenForo_Phrase("mc_assoc_errors_hex_string"), $fieldName);
        }
        return $dw;
    }

    public static function validateColour($value, XenForo_DataWriter $dw, $fieldName) {
        // #fff and #fff444 are acceptable formats here
        if (strlen($value) != 7 && strlen($value) != 4) {
            $dw->error(new XenForo_Phrase("mc_assoc_errors_hex_colour"), $fieldName);
        }
        $truncatedValue = substr($value, 1); // chop off the #
        if (!ctype_xdigit($truncatedValue) || $value[0] != "#") {
            $dw->error(new XenForo_Phrase("mc_assoc_errors_hex_colour"), $fieldName);
        }
        return $dw;
    }

} 