<?php


class backupSphere {
    //Plugin activation hook
    public static function plugin_activation(){

    	global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'backupSphere';

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			admin_name varchar(255) NOT NULL,
			time timestamp NOT NULL,
			status smallint(5) NOT NULL,
			size smallint(100) NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

    }
    //plugin deactivation hook
    public static function plugin_deactivation(){

    	global $wpdb;

	    $table_name = $wpdb->prefix . 'backupSphere';
	    $sql = "DROP TABLE IF EXISTS $table_name";
	    $wpdb->query($sql);
	    delete_option('e34s_time_card_version');

    }
}