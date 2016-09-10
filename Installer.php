<?php

/**
 * Class AssociationMc_Installer
 * Installer for association addon.
 * @author lol768
 */
class AssociationMc_Installer {
    /**
     * @var array Holds the up/down queries used to initialize the tables.
     */
    protected static $table = array(
        'up' =>
            'CREATE TABLE IF NOT EXISTS xf_association_mc
            (
                association_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
                xenforo_id int unsigned NOT NULL,
                minecraft_uuid BINARY(16) NOT NULL,
                last_username VARCHAR(16) NOT NULL,
                display_by_posts TINYINT DEFAULT 1,
                FOREIGN KEY (xenforo_id) REFERENCES xf_user(user_id)
            );',
        'down' => 'DROP TABLE IF EXISTS xf_association_mc'
    );

    /**
     * This function runs our query and initializes everything we need
     * in terms of the database.
     */
    public static function install() {
        if (version_compare(PHP_VERSION, '5.4.0') < 0) {
            throw new XenForo_Exception("AssociationMc requires PHP 5.4 or later!", true);
        }
        /** @var Zend_Db_Adapter_Abstract $db */
        $db = XenForo_Application::get('db');
        if ($db->fetchOne("SHOW TABLES LIKE 'xf_association_mc';") && !$db->fetchOne("SHOW COLUMNS FROM xf_association_mc WHERE Field = \"association_id\";")) {
            $db->query("ALTER TABLE xf_association_mc DROP FOREIGN KEY xf_association_mc_ibfk_1;");
            $db->query("ALTER TABLE xf_association_mc DROP PRIMARY KEY");
            $db->query("ALTER TABLE xf_association_mc ADD CONSTRAINT xf_association_mc_ibfk_1 FOREIGN KEY(xenforo_id) REFERENCES xf_user(user_id);");
            $db->query("ALTER TABLE xf_association_mc ADD COLUMN association_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT;");
            $db->query("ALTER TABLE xf_association_mc ADD COLUMN display_by_posts TINYINT DEFAULT 1;");
        }
        $db->query(self::$table['up']);
    }

    /**
     * Clean up after ourselves.
     */
    public static function uninstall() {
        $db = XenForo_Application::get('db');
        $db->query(self::$table['down']);
    }


} 
