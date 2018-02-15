<?php
/**
 * Created by PhpStorm.
 * User: aubreykodar
 * Date: 2017/11/22
 * Time: 7:43 PM
 * Blog booster sidebar menu
 */

//Register the menu for the following user roles: administrator, author and editor
function backupSphere_register_my_custom_menu_page() {

    $user = wp_get_current_user();

    if(in_array('author',$user->roles)| in_array('administrator',$user->roles)| in_array('editor',$user->roles)){
        backupSphere_setup_menus($user->roles[0]);
    }
}

// Register menu for specified user role
function backupSphere_setup_menus($capability){
    add_menu_page(
        'backupSphere Dashboard',
        'backupSphere',
        $capability,
        'dashboard',
        'backupSphere_dashboard',
        backupSphere__PLUGIN_URL.'/resources/images/icon.png' ,
        6
    );
    add_submenu_page( 'dashboard', 'backupSphere Posts', 'Posts', $capability, 'Posts', 'backupSphere_posts');

}

//Add submenu options
function backupSphere_dashboard(){
    require_once ('dashboard.php');
}