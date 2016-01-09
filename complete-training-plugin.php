<?php
/*
Plugin Name: Complete Training Plugin
Description: The Complete Training Plugin was designed specifically for Connecticut Regional Training for deployment on instructor's individual websites.
Version: 0.0.1
Author: Simplified Web Solutions, LLC
Author URI: //www.simplifiedwebs.com
License: GPLv2 or later
*/

//Define version number...  Used on intial install and checking for updates.
$version = '0.0.1';

//Define Global Variables for use throughout plugin
//Theme Directory
if (!defined('SWSCTP_THEME_DIR'))
    define('SWSCTP_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

//Plugin Name
if (!defined('SWSCTP_PLUGIN_NAME'))
    define('SWSCTP_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

//Plugin Directory
if (!defined('SWSCTP_PLUGIN_DIR'))
    define('SWSCTP_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . SWSCTP_PLUGIN_NAME);

//Plugin URL
if (!defined('SWSCTP_PLUGIN_URL'))
    define('SWSCTP_PLUGIN_URL', WP_PLUGIN_URL . '/' . SWSCTP_PLUGIN_NAME);

//Check for or define Plugin Version Key
if (!defined('SWSCTP_VERSION_KEY'))
    define('SWSCTP_VERSION_KEY', 'myplugin_version');

//Check for or define Plugin Version Number
if (!defined('SWSCTP_VERSION_NUM'))
    define('SWSCTP_VERSION_NUM', $version);

//Add version number to DB for future use... If it exists, nothing executes.
add_option(SWSCTP_VERSION_KEY, SWSCTP_VERSION_NUM);

//Check current version number.  If not current, update.
if (get_option(SWSCTP_VERSION_KEY) != $version) {
    // Execute your upgrade logic here

    // Then update the version value
    update_option(SWSCTP_VERSION_KEY, $version);
}


//Require and include support files
require_once dirname( __FILE__ ) . '/tgm-activation/class-tgm-plugin-activation.php';  //TGM Plugin Activation Class
require_once dirname( __FILE__ ) . '/src/req-plugins.php'; //TGM Required Plugins Defined in here
require_once dirname( __FILE__ ) . '/vendors/jigsaw/jigsaw.php'; //Initialize Jigsaw Plugin for Admin Column Modifications
include_once dirname( __FILE__ ) . '/src/tribe-functions.php'; //Tribe Events Modifications File
include_once dirname( __FILE__ ) . '/src/user-functions.php'; //User Role Functions File
include_once dirname( __FILE__ ) . '/src/column-mods.php'; //User Role Functions File

//Register Activiation Hook
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

//Add Actions
add_action( 'tgmpa_register', 'SWSCTP_register_required_plugins' ); //Register Required plugins from req-plugins.php
add_action( 'admin_init', 'sws_admin_css' ); //Function to provide Bootstrap CSS to WP-admin
add_action( 'admin_init', 'SWSCTP_tribe_functions'); //Function to Add Metabox to Tribe Events
add_action( 'init', 'sws_change_role_name' ); //Change editor role name to "Manager"
add_action( 'after_setup_theme', 'sws_remove_admin_bar' ); //Remove admin bar to non-administrators
add_action( 'save_post', 'save_tribe_events_data' ); //Save Tribe Events Additional Meta-Data
add_action( 'admin_menu' , 'remove_page_author_field' );
add_action( 'plugins_loaded', 'swsctp_class_column_mod'); //Runs Jigsaw Column Modifications to Tribe_Events Post Type Admin Page
//
//
//Remove Actions
//Intended to remove admin notice for installing woothemes updater.
remove_action( 'admin_notices', 'woothemes_updater_notice' );


//Admin Bootstrap CSS inclusion function
function sws_admin_css(){
    wp_enqueue_script('admin_js_bootstrap_hack', plugins_url('/complete-training-plugin/js/bootstrap-hack.js'), false, '1.0.0', false);
    wp_enqueue_script('admin_js_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, '3.3.4', false);
    
}


