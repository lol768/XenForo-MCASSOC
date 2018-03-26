<?php

/**
 * Class Thread_Post
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
        return $this->_getDb()->fetchAll('SELECT * FROM xf_association_mc WHERE xenforo_id = ? AND display_by_posts=1 LIMIT ?', array($userId, $maxCount));
    }

   public function getEntryCountForUserId($userId, $enforceDisplay=false) {
        if ($enforceDisplay) {
            return $this->_getDb()->fetchOne("SELECT COUNT(minecraft_uuid) FROM xf_association_mc WHERE xenforo_id = ? AND display_by_posts = 1 LIMIT 1", $userId);
        }
        return $this->_getDb()->fetchOne("SELECT COUNT(minecraft_uuid) FROM xf_association_mc WHERE xenforo_id = ? AND display_by_posts = 1 LIMIT 1", $userId);
    }
}
