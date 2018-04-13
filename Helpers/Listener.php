<?php

class AssociationMc_Helpers_Listener {

    public static function init(XenForo_Dependencies_Abstract $dependencies, array $data) {
        // Register helper to grab the URL for the skin head image given a size and username
        XenForo_Template_Helper_Core::$helperCallbacks += array(
            'headimage' => array('AssociationMc_Helpers_HeadImage', 'helperGetHeadImageUrl'),
            'additionalinfo' => array('AssociationMc_Helpers_AdditionalInfo', 'helperGetAdditionalInfoUrl')
        );
    }

}
