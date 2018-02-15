<?php /*
Plugin Name: backupSphere
Plugin URI: https://github.com/AubreyKodar/backupSphere_wp_client.git
Description:
Version: 1.0
Author:
Author URI:
License: MIT
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
exit;
}

define( 'BACKUPSHERE_VERSION', '1.0.0' );
define( 'BACKUPSHERE__MINIMUM_WP_VERSION', '4.0' );
define( 'BACKUPSHERE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BACKUPSHERE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );

register_activation_hook( __FILE__, array( 'backupSphere', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'backupSphere', 'plugin_deactivation' ) );

require_once( BACKUPSHERE__PLUGIN_DIR . 'class.backupSphere.php' );
require_once( BACKUPSHERE__PLUGIN_DIR . 'class.backupSphere-rest-api.php' );
require_once (BLOGBOOSTER__PLUGIN_DIR .'/views/menu.php');


add_action( 'admin_menu', 'backupSphere_register_my_custom_menu_page' );

function bb_enqueue_my_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('loadingModal', plugin_dir_url(__FILE__) . 'resources/scripts/jquery.loadingModal.min.js', array('jquery','bootstrap'), null, true);
}

function bb_enqueue_my_styles(){
    wp_enqueue_style('bootstrap',plugin_dir_url(__FILE__) . 'resources/styles/bootstrap.min.css',[], null);
    wp_enqueue_style('bootstrap-theme',plugin_dir_url(__FILE__) . 'resources/styles/bootstrap-theme.min.css',[], null);
    wp_enqueue_style('loadingModal',plugin_dir_url(__FILE__) . 'resources/styles/jquery.loadingModal.min.css',[], null);

}

add_action('admin_print_styles', 'bb_enqueue_my_scripts');
add_action('admin_print_styles', 'bb_enqueue_my_styles');

// Registers the library
wp_register_script('jquery', plugin_dir_url(__FILE__) . 'resources/scripts/jquery.min.js', array(), '', false);
wp_register_script('bootstrap', plugin_dir_url(__FILE__) . 'resources/scripts/bootstrap.min.js', array(), '', false);


//Add blogbooster Rest
add_action( 'rest_api_init', array( 'backupSphere_rest', 'init' ) );