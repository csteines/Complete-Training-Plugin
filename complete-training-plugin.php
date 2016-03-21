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

if (!defined('SWSCTP_THEME_URI'))
    define('SWSCTP_THEME_URI', get_template_directory_uri());

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

if (!defined('SWSCTP_TRIBE_FILE_VERS'))
    define('SWSCTP_TRIBE_FILE_VERS', 'SWSCTP_VERSION = '.$version);

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
include_once dirname( __FILE__ ) . '/src/shortcode-functions.php'; //Shortcode Definitions File
include_once dirname( __FILE__ ) . '/settings/settings.php'; //Settings & Options Functions File

add_query_arg('swsctp');

//Register Activiation Hook
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

//Add Actions
add_action( 'tgmpa_register', 'SWSCTP_register_required_plugins' ); //Register Required plugins from req-plugins.php
add_action( 'admin_init', 'sws_admin_css' ); //Function to provide Bootstrap CSS to WP-admin
add_action( 'admin_init', 'SWSCTP_tribe_functions'); //Function to Add Metabox to Tribe Events
add_action( 'init', 'sws_change_role_name' ); //Change editor role name to "Manager"
add_action( 'init', 'swsctp_inst_sign_decline' ); //Process Sign/Decline Form Submission
add_action( 'after_setup_theme', 'sws_remove_admin_bar' ); //Remove admin bar to non-administrators
add_action( 'save_post', 'save_tribe_events_data' ); //Save Tribe Events Additional Meta-Data
add_action( 'admin_menu' , 'remove_page_author_field' );
add_action( 'plugins_loaded', 'swsctp_class_column_mod'); //Runs Jigsaw Column Modifications to Tribe_Events Post Type Admin Page
add_action( 'plugins_loaded', 'include_tribe_reg_email'); //Ensures Tribe Events Registration email template override file has been placed in theme directory
add_action( 'plugins_loaded', 'include_tribe_single_event'); //Ensure Tribe Events Single Event template override file has been placed in theme directory
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' ); //Enqueue additional styles and scripts as needed
add_action( 'wp_enqueue_scripts', 'swsctp_modal_scripts'); //Enqueue additional styles and scripts for modal windows for instructor accept/decline form

function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'swsctp-styles', plugins_url('/complete-training-plugin/css/styles.css'), '0.0.1');
    //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

//Remove Actions
//Intended to remove admin notice for installing woothemes updater.
remove_action( 'admin_notices', 'woothemes_updater_notice' );


//Admin Bootstrap CSS inclusion function
function sws_admin_css(){
    wp_enqueue_script('admin_js_bootstrap_hack', plugins_url('/complete-training-plugin/js/bootstrap-hack.js'), false, '1.0.0', false);
    wp_enqueue_script('admin_js_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', false, '3.3.4', false);
    wp_enqueue_style('swsctp_admin_styles', plugins_url('/complete-training-plugin/css/admin-styles.css'), false, '1.0.0', false);
}

//Register Query Vars and Rewrite Tags
add_filter('query_vars', 'swsctp_add_my_var');
function swsctp_add_my_var($public_query_vars) {
	$public_query_vars[] = 'inst_view';
	return $public_query_vars;
}


