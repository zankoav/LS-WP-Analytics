<?php 

class LS_WP_Analytics {
    
    const TABLE_NAME = 'ls_wp_analytics';

    public static function init(){
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        maybe_create_table(
            self::TABLE_NAME, 
            "CREATE TABLE " . self::TABLE_NAME . " (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                is_home BOOLEAN,
                is_archive BOOLEAN,
                slug VARCHAR(255),
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) CHARSET=utf8 COLLATE=utf8_general_ci"
        );
    }
    
    public static function insert($is_home, $is_archive, $slug) {
        global $wpdb;
        return $wpdb->query("INSERT INTO `ls_wp_analytics`(`is_archive`,`is_home`,`slug`) VALUES ('$is_archive', '$is_home', '$slug')");
    }

    public static function removeTable() {
        global $wpdb;
        $wpdb->query( 'DROP TABLE ' . self::TABLE_NAME);
    }
}