<?php

class AssociationMc_Utility_WidgetColours {

    public static function buildObjectFromPalette(array $palette) {
        return [
            "borderBg" => $palette['primaryDarker'],
            "borderFg" => $palette['primaryLightest'],
            "boxBg" => $palette['primaryDark'],
            "boxFg" => $palette['primaryLighterStill'],
            "contentBg" => $palette['contentBackground'],
            "contentFg" => $palette['contentText']
        ];
    }

}
