<?php

/* 
 * settings.php
 * 
 * This file contains all the settings registrations and options page functions
 * to provide user customizations from the administrative panel
 * 
 */

function swsctp_get_default_options() {
    $swsctp_options = array(
        'logo' => '',
        'cont_agrmnt' => '',
        'sig_needed_reminder_time' => '3',
        'course_reminder_time' => '2',
        'init_notice' => 'true',
        'require_sig' => 'true'
    );
    return $swsctp_options;
}

function swsctp_options_init() {
    $swsctp_options = get_option( 'swsctp_options' );
 
    // Are our options saved in the DB?
    if ( false === $swsctp_options ) {  
        // If not, we'll save our default options
        $swsctp_options = swsctp_get_default_options();
        add_option( 'swsctp_options', $swsctp_options );
    }
 
    // In other case we don't need to update the DB
}
 
// Initialize Plugin options
add_action( 'admin_init', 'swsctp_options_init' );


// Add "WPTuts Options" link to the "Appearance" menu
function swsctp_menu_options() {
    // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
    add_menu_page('Complete Training Plugin', 'Training', 'manage_options', 'swsctp-settings', 'swsctp_admin_options_page', 'dashicons-welcome-learn-more', '6.9');
    add_submenu_page( 'swsctp-settings', 'Classes', 'Classes', 'edit_posts', 'edit.php?post_type=tribe_events');
    add_submenu_page( 'swsctp-settings', 'Add New', 'Add New', 'edit_posts', 'post-new.php?post_type=tribe_events');
    
    //remove_menu_page( 'edit.php?post_type=tribe_events' );
}
// Load the Admin Options page
add_action('admin_menu', 'swsctp_menu_options');
 
function swsctp_admin_options_page() {
    //Check if page is loading after settings update
    if ( ! isset( $_REQUEST['settings-updated'] ) )  $_REQUEST['settings-updated'] = false;
    
    ?><!-- 'wrap','submit','icon32','button-primary' and 'button-secondary' are classes
        for a good WP Admin Panel viewing and are predefined by WP CSS -->
 
        <div class="wrap">
 
            <div id="icon-themes" class="icon32"><br /></div>
 
            <h2><?php _e( 'Complete Training Plugin', 'swsctp' ); ?></h2>
 
            <!-- If we have any error by submiting the form, they will appear here -->
            <?php settings_errors( 'swsctp-settings-errors' );
            //If settings updated, show settings updated notice
            if ( false !== $_REQUEST['settings-updated'] ){ ?>
               <div class="updated fade"><p><strong><?php _e( 'Settings saved.', 'swsctp' ); ?></strong></p></div>
            <?php } ?>
            <form id="form-swsctp-options" action="options.php" method="post" enctype="multipart/form-data">
 
                <?php
                    settings_fields('swsctp_options');
                    do_settings_sections('swsctp');
                ?>
 
                <p class="submit">
                    <input name="swsctp_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'swsctp'); ?>" />
                    <input name="swsctp_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'swsctp'); ?>" />
                </p>
 
            </form>
 
        </div>
    <?php
}

function swsctp_options_settings_init() {
    register_setting( 'swsctp_options', 'swsctp_options', 'swsctp_options_validate' );
 
    // Add a form section for the Logo
    add_settings_section('swsctp_settings', __( 'Settings', 'swsctp' ), 'swsctp_settings_content', 'swsctp');

}
add_action( 'admin_init', 'swsctp_options_settings_init' );
 
function swsctp_settings_content() {
    //Add Upload Logo Field and preview line
    add_settings_field('swsctp_setting_logo',  __( 'Email Header Logo', 'swsctp' ), 'swsctp_setting_logo', 'swsctp', 'swsctp_settings'); 
    add_settings_field('swsctp_setting_logo_preview',  __( 'Logo Preview', 'swsctp' ), 'swsctp_logo_preview', 'swsctp', 'swsctp_settings');
    //Add Instructor Notification Fields
    add_settings_field('swsctp_setting_require_sig',  __( 'Require Instructors to Sign &amp; Accept Classes?', 'swsctp' ), 'swsctp_setting_require_sig', 'swsctp', 'swsctp_settings'); 
    add_settings_field('swsctp_setting_cont_agrmnt',  __( 'Contractor Agreement', 'swsctp' ), 'swsctp_setting_cont_agrmnt', 'swsctp', 'swsctp_settings'); 
    add_settings_field('swsctp_setting_init_notice',  __( 'Send Instructors Intial Notice?', 'swsctp' ), 'swsctp_setting_init_notice', 'swsctp', 'swsctp_settings'); 
    add_settings_field('swsctp_setting_sig_needed_notice',  __( 'Signature Needed Reminder Notice', 'swsctp' ), 'swsctp_setting_sig_needed_notice', 'swsctp', 'swsctp_settings'); 
    add_settings_field('swsctp_setting_class_reminder_notice',  __( 'Instructor Class Reminder Notice', 'swsctp' ), 'swsctp_setting_class_remind_notice', 'swsctp', 'swsctp_settings'); 
    
}
 
function swsctp_setting_logo() {
    $swsctp_options = get_option( 'swsctp_options' );
    ?><input type="hidden" id="logo_url" name="swsctp_options[logo]" value="<?php echo esc_url( $swsctp_options['logo'] ); ?>" />
        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'swsctp' ); ?>" />
        <br><span class="description"><?php _e('Upload an image for the email header.<br>This will be included in all emails to customers and instructors.', 'swsctp' ); ?></span><?php
}

function swsctp_options_validate( $input ) {
    $default_options = swsctp_get_default_options();
    $valid_input = $default_options;
 
    $submit = ! empty($input['submit']) ? true : false;
    $reset = ! empty($input['reset']) ? true : false;
 
    if ( $submit ){
        $valid_input['logo'] = $input['logo'];
        $valid_input['cont_agrmnt'] = $input['cont_agrmnt'];
        $valid_input['sig_needed_reminder_time'] = $input['sig_needed_reminder_time'];
        $valid_input['course_reminder_time'] = $input['course_reminder_time'];
        $valid_input['init_notice'] = $input['init_notice'];
        $valid_input['require_sig'] = $input['require_sig'];
    }
    elseif ( $reset ){
        $valid_input['logo'] = $default_options['logo'];
        $valid_input['cont_agrmnt'] = $default_options['cont_agrmnt'];
        $valid_input['sig_needed_reminder_time'] = $default_options['sig_needed_reminder_time'];
        $valid_input['course_reminder_time'] = $default_options['course_reminder_time'];
        $valid_input['init_notice'] = $default_options['init_notice'];
        $valid_input['require_sig'] = $default_options['require_sig'];
    }
 
    return $valid_input;
}

//Scripts required for media uploader/selector for Email Header Logo
function swsctp_options_enqueue_scripts() {
    wp_register_script( 'swsctp-upload', SWSCTP_PLUGIN_URL . '/settings/swsctp-upload.js', array('jquery','media-upload','thickbox') );
    error_log(get_current_screen() -> id);
    if ( 'toplevel_page_swsctp-settings' == get_current_screen() -> id ) {
        wp_enqueue_script('jquery');
 
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
 
        wp_enqueue_script('media-upload');
        wp_enqueue_script('swsctp-upload');
        
        wp_enqueue_media();
 
    }
 
}
add_action('admin_enqueue_scripts', 'swsctp_options_enqueue_scripts');


function swsctp_options_setup() {
    global $pagenow;
 
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
    }
}
add_action( 'admin_init', 'swsctp_options_setup' );
 
//Translation function to change media upload/selector "Insert Into Post" button
function replace_thickbox_text($translated_text, $text, $domain) {
    if ('Insert into Post' == $text) {
        $referer = strpos( wp_get_referer(), 'swsctp-settings' );
        if ( $referer != '' ) {
            return __('Set as email logo', 'swsctp' );
        }
    }
    return $translated_text;
}

//Displays Logo Image in form
function swsctp_logo_preview() {
    $swsctp_options = get_option( 'swsctp_options' );  ?>
    <div id="upload_logo_preview" style="min-height: 100px;">
        <img style="max-width:100%;" src="<?php echo esc_url( $swsctp_options['logo'] ); ?>" />
    </div>
    <?php
}

//Is signature required?
function swsctp_setting_require_sig(){
    $swsctp_options = get_option( 'swsctp_options' );?>
        <div class="swsctp-options-radio"><input type="radio" name="swsctp_options[require_sig]" value="true" <?php if($swsctp_options['require_sig'] == 'true'){echo "checked";} ?>> Require instructors to accept class assignment &amp; sign contract </div>
        <div class="swsctp-options-radio"><input type="radio" name="swsctp_options[require_sig]" value="false" <?php if($swsctp_options['require_sig'] == 'false'){echo "checked";} ?>> <i>DO NOT</i> require instructors to accept class assignment &amp; sign contract </div>
    <?php
}

//Contractor Agreement WP_Editor
function swsctp_setting_cont_agrmnt(){
    $swsctp_options = get_option( 'swsctp_options' );
    $wpe_args = array(
            'media_buttons' => false,
            'textarea_rows' => 10,
            'textarea_name' => 'swsctp_options[cont_agrmnt]',
            'wpautop' => false
        );
    wp_editor( stripslashes($swsctp_options['cont_agrmnt']), 'cont_agrmnt', $wpe_args );
    ?><br><span class="description"><?php _e('You may enter the following shortcodes here for auto-population of content: [instructor_name], [instructor_rate], [location], [full_location], [start_date_time], [sign_date], [sign_month], [sign_year], [class_name], [instructor_address]', 'swsctp' ); ?></span><?php
        
}

//Send initial notice upon class assignment
function swsctp_setting_init_notice(){
    $swsctp_options = get_option( 'swsctp_options' );?>
        <div class="swsctp-options-radio"><input type="radio" name="swsctp_options[init_notice]" value="true" <?php if($swsctp_options['init_notice'] == 'true'){echo "checked";} ?>> Send initial notice to instructor(s) upon assignment of class </div>
        <div class="swsctp-options-radio"><input type="radio" name="swsctp_options[init_notice]" value="false" <?php if($swsctp_options['init_notice'] == 'false'){echo "checked";} ?>> <i>DO NOT</i> send initial notice to instructor(s) upon assignment of class</div>
    <?php
}

//Frequency of signautre needed notices
function swsctp_setting_sig_needed_notice(){
    $swsctp_options = get_option( 'swsctp_options' );  ?>
        <div class="swsctp-options-inline-number"><label for="swsctp_options[sig_needed_reminder_time]">Send "Signature Needed" notice every </label><input type="number" name="swsctp_options[sig_needed_reminder_time]" id="sig_needed_reminder_time" value="<?php echo $swsctp_options['sig_needed_reminder_time'];?>"><label for="swsctp_options[sig_needed_reminder_time]"> days.</label></div>
    <?php
}

//Class reminder sent X days prior to start of class
function swsctp_setting_class_remind_notice(){
    $swsctp_options = get_option( 'swsctp_options' );  ?>
        <div class="swsctp-options-inline-number"><label for="swsctp_options[course_reminder_time]">Remind instructor(s) of class </label><input type="number" name="swsctp_options[course_reminder_time]" id="course_reminder_time" value="<?php echo $swsctp_options['course_reminder_time'];?>"><label for="swsctp_options[course_reminder_time]"> days prior to the class.</label></div>
    <?php
  
}
?>