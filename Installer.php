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
    protected static $table = [
        'up' =>
            'CREATE TABLE IF NOT EXISTS xf_association_mc
            (
                xenforo_id int unsigned PRIMARY KEY NOT NULL,
                minecraft_uuid BINARY(16) NOT NULL,
                last_username VARCHAR(16) NOT NULL,
                FOREIGN KEY (xenforo_id) REFERENCES xf_user(user_id)
            );',
        'down' => 'DROP TABLE IF EXISTS xf_association_mc'
    ];

    /**
     * This function runs our query and initializes everything we need
     * in terms of the database.
     */
    public static function install() {
        $db = XenForo_Application::get('db');
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