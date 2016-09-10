<?php

class AssociationMc_DataWriter_AssociationEntry extends XenForo_DataWriter {

    protected function _getFields() {
        return array(
            'xf_association_mc' => array(
                'association_id' => array( // autoinc id
                    'type' => self::TYPE_UINT,
                ),
                'xenforo_id' => array( // XenForo user id
                                       'type' => self::TYPE_UINT,
                ),
                'minecraft_uuid' => array( // Minecraft UUID (16 bytes)
                                           'type' => self::TYPE_BINARY,
                                           'required' => true
                ),
                'last_username' => array( // Last known username
                                          'type' => self::TYPE_STRING,
                                          'required' => true,
                ),
                'display_by_posts' => array( // Show by posts?
                                        'type' => self::TYPE_UINT,
                                        'default' => 1,
                                        'required' => false,
                )
            )
        );
    }

    protected function _getExistingData($data) {
        // Check by existing primary key ('association_id')
        if (!$id = $this->_getExistingPrimaryKey($data, 'association_id')) {
            return false;
        }
        return array('xf_association_mc' => $this->_getAssociationEntryModel()->getEntryByAssociationId($id));
    }

    protected function _getUpdateCondition($tableName) {
        // Primary keys equal
        return 'association_id = ' . $this->_db->quote($this->getExisting('association_id'));
    }

    /**
     * Disassociate any other users tied to the same UUID.
     *
     * @throws XenForo_Exception
     */
    protected function _preSave() {
        $db = $this->_db;
        if ($this->isInsert()) {
            $db->query("DELETE FROM `xf_association_mc` WHERE `minecraft_uuid` = ?", $this->get("minecraft_uuid"));
        }
    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }
}
