<?php

/* 
 * settings.php
 * 
 * This file contains all the settings registrations and options page functions
 * to provide user customizations from the administrative panel
 * 
 */

/*
 * Create new Top-Level Admin Menu Page for The Complete Training Plugin
 */
add_action( 'admin_menu', 'swsctp_register_my_custom_menu_page' );

function swsctp_register_my_custom_menu_page() {

	add_menu_page( 'Complete Training Plugin - Options', 'Training', 'edit_posts', 'swsctp_options', 'swsctp_options_page', 'dashicons-welcome-learn-more', '6.9' );

}


/*
 * Add an admin submenu link under Settings
 */
/*function swsctp_config_options_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=tribe_events',          // admin page slug
        __( 'CTP Options', 'swsctp' ), // page title
        __( 'CTP Options', 'swsctp' ), // menu title
        'manage_options',               // capability required to see the page
        'swsctp_options',                // admin page slug, e.g. options-general.php?page=swsctp_options
        'swsctp_options_page'            // callback function to display the options page
    );
     
}
add_action( 'admin_menu', 'swsctp_config_options_submenu_page' );
*/

/**
 * Register the settings
 */
function swsctp_register_settings() {
    register_setting(
        'swsctp_options',  // settings section
        'swsctp_options_array' // setting name
    );
}
add_action( 'admin_init', 'swsctp_register_settings' );
 
/**
 * Build the options page
 */
function swsctp_options_page() {
    if ( ! isset( $_REQUEST['settings-updated'] ) ){
       $_REQUEST['settings-updated'] = false; 
    }
     
    $wpe_args = array(
        'media_buttons' => false,
        'textarea_rows' => 10
    );
    
?>

    
 
     <div class="wrap">
 
          <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
               <div class="updated fade"><p><strong><?php _e( 'CTP Options saved!', 'swsctp' ); ?></strong></p></div>
          <?php endif; ?>
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
           
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">
                        <form action="options.php" method="post" enctype="multipart/form-data">
                            <?php settings_fields( 'swsctp_options' ); ?>
                            <?php $options = get_option( 'swsctp_options_array' ); ?>
                            <table class="form-table">
                                <tr valign="top"><th scope="row"><?php _e( 'Hide the post meta information on posts?', 'swsctp' ); ?></th>
                                    <td>
                                        <select name="swsctp_options_array[hide_meta]" id="hide-meta">
                                            <?php $selected = $options['hide_meta']; ?>
                                            <option value="1" <?php selected( $selected, 1 ); ?> >Yes, hide the post meta!</option>
                                            <option value="0" <?php selected( $selected, 0 ); ?> >No, show my post meta!</option>
                                        </select><br />
                                        <label class="description" for="swsctp_options_array[hide_meta]"><?php _e( 'Toggles whether or not to display post meta under posts.', 'swsctp' ); ?></label>
                                    </td>
                               </tr>
                               <tr valign="top"><th scope="row"><?php _e( 'Contractor Agreement Statement', 'swsctp' ); ?></th>
                                    <td>
                                        <?php wp_editor( stripslashes($options['cont_agrmnt']), 'swsctp_options_array[cont_agrmnt]', $wpe_args ); ?>
                                        <label class="description" for="swsctp_options_array[cont_agrmnt]"><?php _e( 'This is the contractor agreement that will be displayed for instructors to "sign & accept" courses.  You may use shortcodes such as [inst_name], [class_date_time], etc.', 'swsctp' ); ?></label>
                                    </td>
                               </tr>
                               <tr valign="top"><th scope="row"><?php _e( 'Registrations Email Logo', 'swsctp' ); ?></th>
                                    <td>
                                        <input type="text" id="logo_url" name="swsctp_options_array[reg_email_logo]" value="<?php echo esc_url( $swsctp_options_array['reg_email_logo'] ); ?>" />
                                        <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'swsctp' ); ?>" />
                                        <span class="description"><?php _e('Upload an image for the banner.', 'swsctp' ); ?></span> 
                                    </td>
                               </tr>
                               <tr valign="top"><th scope="row"></th>
                                    <td>
                                        <input type="submit" name="swsctp_save" value="Save Changes" class="button-primary"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div> <!-- end post-body-content -->
               </div> <!-- end post-body -->
          </div> <!-- end poststuff -->
     </div>
<?php }

?>


