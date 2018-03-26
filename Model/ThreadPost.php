<?php

/**
 * Class AssociationEntry
 * This is the model for the xf_association_mc table.
 */
class AssociationMc_Model_ThreadPost extends XenForo_Model {

    /**
     * Gets all association entries by user id.
     * NB: this returns the raw UUID representation.
     *
     * @param int $userId The XenForo user id.
     * @return mixed
     */
    public function getEntriesByUserId($userId, $enforceDisplay=false) {
        if ($enforceDisplay) {
            return $this->_getDb()->fetchAll('SELECT * FROM xf_association_mc WHERE xenforo_id = ? AND display_by_posts=1', $userId);
        }
        $maxCount = XenForo_Application::get('options')->maxAccountsDisplaySidebar;
        return $this->_getDb()->fetchAll('SELECT * FROM xf_association_mc WHERE xenforo_id = ? LIMIT ?', array($userId, $maxCount));
    }

    /**
     * @param mixed $uuid Raw binary representation of the uuid
     * @param int $userId The XenForo user ID
     * @return array The data
     */
    public function getEntryByMinecraftUuidAndUserId($uuid, $userId) {
        return $this->_getDb()->fetchRow('SELECT * FROM xf_association_mc WHERE xenforo_id = ? AND minecraft_uuid = ? LIMIT 1', [$userId, $uuid]);
    }

    public function getEntryByAssociationId($assocId) {
        return $this->_getDb()->fetchRow('SELECT * FROM xf_association_mc WHERE association_id = ? LIMIT 1', $assocId);
    }

    /**
     * Gets an association entry by UUID.
     * @param string $uuid Hex representation of UUID
     * @throws AssociationMc_InvalidUuidException
     * @return mixed
     */
    public function getEntryByMinecraftUuid($uuid) {
        if (strlen($uuid) !== 32) {
            // 32 characters = 32 nibbles = 128 bits = 16 bytes
            throw new AssociationMc_InvalidUuidException("UUID must be 32 characters");
        }

        if (!ctype_xdigit($uuid)) {
            throw new AssociationMc_InvalidUuidException("UUID must consist of 32 hexadecimal characters. Hyphens are superfluous and should not be used.");
        }
        return $this->_getDb()->fetchRow('SELECT * FROM xf_association_mc WHERE HEX(minecraft_uuid) = ? LIMIT 1', $uuid);
    }

    public function getAll() {
        return $this->_getDb()->fetchAll("SELECT xenforo_id, last_username, HEX(minecraft_uuid) as minecraft_uuid FROM xf_association_mc");
    }

    public function getEntriesByUserIds(array $ids, $justNames=false) {
        if ($justNames) {
            $sql = "SELECT * FROM xf_association_mc WHERE xenforo_id IN (" . $this->_getDb()->quote($ids) . ")";
        } else {
            $sql = "SELECT (xenforo_id, last_username) FROM xf_association_mc WHERE xenforo_id IN (" . $this->_getDb()->quote($ids) . ")";
        }
        return $this->_getDb()->fetchAll($sql);
    }

    /**
     * Gets association entries by last known username. May be multiple.
     * Do not rely on usernames to be unique.
     * @param string $username Username to lookup. May not be more than 16 characters.
     * @throws AssociationMc_InvalidUsernameException
     * @return mixed
     */
    public function getEntriesByUsername($username) {
        if (strlen($username) > 16 || strlen($username) < 1) {
            throw new AssociationMc_InvalidUsernameException("Username length is invalid.");
        }
        return $this->_getDb()->fetchAll('SELECT * FROM xf_association_mc WHERE last_username = ?', $username);
    }

    public function deleteEntriesByUserIdEfficiently($userId) {
        $this->_getDb()->delete("xf_association_mc", 'xenforo_id = ' . $this->_getDb()->quote($userId));
    }

    public function getEntryCountForUserId($userId, $enforceDisplay=false) {
        if ($enforceDisplay) {
            return $this->_getDb()->fetchOne("SELECT COUNT(minecraft_uuid) FROM xf_association_mc WHERE xenforo_id = ? AND display_by_posts = 1 LIMIT 1", $userId);
        }
        return $this->_getDb()->fetchOne("SELECT COUNT(minecraft_uuid) FROM xf_association_mc WHERE xenforo_id = ? LIMIT 1", $userId);
    }
} 
