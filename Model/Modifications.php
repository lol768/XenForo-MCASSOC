<?php
class AssociationMc_Model_Modifications
{
        public static function copyrightNotice(array $matches)
        {
                return $matches[0] .
                        '<xen:if is="!{$mctcopyright}">' .
                        '<xen:set var="$mctcopyright">1</xen:set>' .
                        '<br/>Some Modificatations by <a href="https://mctrades.org/" title="MCTrades" target="_blank">MCTrades</a>.' .
                        '</xen:if>';
        }
}
