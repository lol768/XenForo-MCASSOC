<?php

class AssociationMc_ControllerPublic_View extends XenForo_ControllerPublic_Abstract {

    public function actionIndex() {
        return $this->actionView();
    }

    public static function getSessionActivityDetailsForList(array $activities) {
        return new XenForo_Phrase('mc_assoc_managing_assoc');
    }

    public function actionView() {
        $visitor = XenForo_Visitor::getInstance();
        if (!$visitor->getUserId()) {
            return $this->responseNoPermission();
        }

        $model = $this->getAssociationEntryModel();
        $entries = $model->getEntriesByUserId($visitor->getUserId());
        $mcassoc = $this->getMcAssoc();

        $user = $visitor['username'];
        $return_link = $this->getConfirmUrl($user);

        $key = $mcassoc->generateKey($user);
        $find = $this->_input->filterSingle('stage', XenForo_Input::UNUM);

        $mcAssocData = array(
            "siteId" => $mcassoc->getSiteId(),
            "key" => $key,
            "stage" => $find,
            "retLink" => $return_link,
            "colours" => $this->buildColourObj(),
            "safeUsername" => json_encode($visitor['username']),
            "maxDisplayable" => XenForo_Application::get('options')->maxAccountsDisplaySidebar
        );

        if (count($entries) != 0) {
            foreach ($entries as &$entry) {
                $entry['minecraft_uuid'] = bin2hex($entry['minecraft_uuid']);
            }
            return $this->actionManage($visitor, $entries, $mcAssocData);
        }




        return $this->responseView('AssociationMc_ViewPublic_View', 'association_view', array(
            "associated" => false) + $mcAssocData);
    }

    private function buildColourObj() {
        $opts = XenForo_Application::get('options');
        $obj = [
            "borderBg" => $opts->mcAssocStyleOuterBorderBg,
            "borderFg" => $opts->mcAssocStyleOuterBorderFg,
            "boxBg" => $opts->mcAssocStyleBoxBg,
            "boxFg" => $opts->mcAssocStyleBoxFg,
            "contentBg" => $opts->mcAssocStyleContentBg,
            "contentFg" => $opts->mcAssocStyleContentFg
        ];

        if ($opts->mcAssocUseColourPalette) {
            $styleId = XenForo_Visitor::getInstance()['style_id'];
            $palette = $this->getColourPalette($styleId);
            $obj = AssociationMc_Utility_WidgetColours::buildObjectFromPalette($palette);
        }
        
        return json_encode($obj);

    }

    private function getConfirmUrl($username) {
        $link = XenForo_Link::buildPublicLink("full:mc-association/confirm", null, array(
            'stage' => '3',
            'username' => $username
        ));
        return $link;
    }

    private function getMcAssoc() {
        $opts = XenForo_Application::get('options');
        return new AssociationMc_MCAssoc($opts->mcAssocSiteId, $opts->mcAssocSharedSecret, $opts->mcAssocInstanceSecret);
    }

    private function getColourPalette($styleId) {
        $propertyModel = $this->getStylePropertyModel();

        $colors = $propertyModel->getColorPalettePropertiesInStyle($styleId);
        $colors = $propertyModel->prepareStyleProperties($colors);
        $colourHashMap = [];
        foreach ($colors as $item) {
            $colourHashMap[$item['property_name']] = $this->standardiseColour($item['property_value']);
        }
        return $colourHashMap;
    }


    /**
     * Get our model.
     *
     * @return AssociationMc_Model_AssociationEntry
     */
    private function getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }

    private function actionManage($visitor, $entries, $mcAssocData) {
        $viewData = array(
                "associated" => true,
                "entries" => $entries,
            ) + $mcAssocData;
        return $this->responseView('AssociationMc_ViewPublic_View', 'association_view', $viewData);
    }

    /**
     * Grabs the style property model.
     *
     * @return XenForo_Model_StyleProperty
     */
    private function getStylePropertyModel() {
        return $this->getModelFromCache("XenForo_Model_StyleProperty");
    }

    private function standardiseColour($propertyValue) {
        $propertyValue = str_replace(" ", "", strtolower($propertyValue));
        $matches = [];
        if (preg_match("/(?:^#[a-f0-9]{3}$)|(?:^#[a-f0-9]{6}$)/", $propertyValue)) {
            return $propertyValue;
        } else if (preg_match('/rgb\(([0-9]{1,3}),([0-9]{1,3}),([0-9]{1,3})\)/', $propertyValue, $matches)) {
            return "#" . base_convert($matches[1], 10, 16) . base_convert($matches[2], 10, 16) . base_convert($matches[3], 10, 16);
        } else if (preg_match('/rgba\(([0-9]{1,3}),([0-9]{1,3}),([0-9]{1,3}),([0-9\.]+)\)/', $propertyValue, $matches)) {
            return "#" . base_convert($matches[1], 10, 16) . base_convert($matches[2], 10, 16) . base_convert($matches[3], 10, 16);
        }
    }
} 
