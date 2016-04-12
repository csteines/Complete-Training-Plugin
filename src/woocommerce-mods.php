<?php 

//Copies CTP Modified The Events Calendar Email Template to Theme Override Directory
//Checks file for Version Number to ensure file is up-to-date
function include_woo_email_header(){
    $filename = SWSCTP_THEME_DIR . '/woocommerce/emails/email-header.php';
    if(file_exists($filename)){
        $old_contents = file_get_contents($filename);
        
        if(!strpos($old_contents, SWSCTP_TRIBE_FILE_VERS)){
            $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/notifications-header.php');
            $put_file = file_put_contents($filename, $new_contents);
            
            return $put_file;
        }
        
        else{
            return "Up-To-Date";
        }
    }
    
    else{
        if(!file_exists(SWSCTP_THEME_DIR.'/woocommerce/')) mkdir(SWSCTP_THEME_DIR. '/woocommerce/', 0755);
        if(!file_exists(SWSCTP_THEME_DIR.'/woocommerce/emails/')) mkdir(SWSCTP_THEME_DIR . '/woocommerce/emails/', 0755);
        
        touch($filename);
        $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/notifications-header.php');
        $put_file = file_put_contents($filename, $new_contents);
            
        return $put_file;
    }
}


//Copies CTP Modified The Events Calendar Email Template to Theme Override Directory
//Checks file for Version Number to ensure file is up-to-date
function include_woo_email_footer(){
    $filename = SWSCTP_THEME_DIR . '/woocommerce/emails/email-footer.php';
    if(file_exists($filename)){
        $old_contents = file_get_contents($filename);
        
        if(!strpos($old_contents, SWSCTP_TRIBE_FILE_VERS)){
            $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/notifications-footer.php');
            $put_file = file_put_contents($filename, $new_contents);
            
            return $put_file;
        }
        
        else{
            return "Up-To-Date";
        }
    }
    
    else{
        if(!file_exists(SWSCTP_THEME_DIR.'/woocommerce/')) mkdir(SWSCTP_THEME_DIR. '/woocommerce/', 0755);
        if(!file_exists(SWSCTP_THEME_DIR.'/woocommerce/emails/')) mkdir(SWSCTP_THEME_DIR . '/woocommerce/emails/', 0755);
        
        touch($filename);
        $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/notifications-footer.php');
        $put_file = file_put_contents($filename, $new_contents);
            
        return $put_file;
    }
}




function swsctp_wootickets_email_message( $message ) {

    $message = "You'll receive your registration confirmation in another email.";

    return $message;
}

add_filter( 'wootickets_email_message', 'swsctp_wootickets_email_message');


function swsctp_wootickets_email_subject( $subject ){
    $site_name = get_option('blogname');
    $subject = "Your Registration Confirmation from $site_name";
    
    return $subject;
}
add_filter( 'wootickets_ticket_email_subject', 'swsctp_wootickets_email_subject');


/**
 * Change text strings
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
 */
function swsctp_text_strings( $translated_text, $text, $domain ) {
    if( !is_admin() ){
        switch ( $translated_text ) {
		case 'Tickets' :
                    $translated_text = esc_html_e( 'Registrations', 'event-tickets-plus' );
                    break;
	}
    }
    return $translated_text;
}
add_filter( 'gettext', 'swsctp_text_strings', 20, 3 );