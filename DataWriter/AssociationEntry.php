<?php

class AssociationMc_DataWriter_AssociationEntry extends XenForo_DataWriter {

    protected function _getFields() {
        return array(
            'xf_association_mc' => array(
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
            )
        );
    }

    protected function _getExistingData($data) {
        // Check by existing primary key ('xenforo_id')
        if (!$id = $this->_getExistingPrimaryKey($data, 'xenforo_id')) {
            return false;
        }
        return array('xf_association_mc' => $this->_getAssociationEntryModel()->getEntryById($id));
    }

    protected function _getUpdateCondition($tableName) {
        // Primary keys equal
        return 'xenforo_id = ' . $this->_db->quote($this->getExisting('xenforo_id'));
    }

    /**
     * @return AssociationMc_Model_AssociationEntry
     */
    private function _getAssociationEntryModel() {
        return $this->getModelFromCache('AssociationMc_Model_AssociationEntry');
    }
}