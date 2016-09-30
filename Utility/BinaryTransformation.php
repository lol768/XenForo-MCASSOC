<?php

class AssociationMc_Utility_BinaryTransformation {

    public static function convertEntriesToHumanReadableUuids(array &$entries) {
        foreach ($entries as &$entry) {
            $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
        }
    }

}