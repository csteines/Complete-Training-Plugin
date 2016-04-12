<?php
/*
 * Tribe Events Functions
 * Modifying the Tribe Events Custom Post Type 
 * 
 * version: 0.0.1
 */


/**
* Add custom options to General Settings page
* Options added allow for different default from email address and name
*
* @param  $fromname
* @return $name_new || $fromname
*/
$new_general_setting = new swsctp_new_general_setting();
class swsctp_new_general_setting {
    function swsctp_new_general_setting( ) {
        ////error_log(__FUNCTION__);
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'swsint-default-email', 'sanitize_email' );
        add_settings_field('swsint-default-email', '<label for="swsint-default-email">'.__('Default FROM Email Address' , 'swsint-default-email' ).'</label>' , array(&$this, 'email_fields_html') , 'general' );
    
        register_setting( 'general', 'swsint-default-name', 'esc_attr' );
        add_settings_field('swsint-default-name', '<label for="swsint-default-name">'.__('Default FROM Email Name' , 'swsint-default-name' ).'</label>' , array(&$this, 'name_fields_html') , 'general' );
    }
    function email_fields_html() {
        $value = get_option( 'swsint-default-email', '' );
        echo '<input type="text" id="swsint-default-email" name="swsint-default-email" value="' . $value . '" />';
        echo '<br><span class="description">Using a different domain (i.e., @domain.com) may cause email to be filtered as SPAM.</span>';
    }
    function name_fields_html() {
        $value = get_option( 'swsint-default-name', '' );
        echo '<input type="text" id="swsint-default-name" name="swsint-default-name" value="' . $value . '" />';
    }
}

/**
* Change default email from address.
* Gets custom option so "admin email" is not used for all correspondence.
*
* @param  $email_old
* @return $email_new|| $email_old
*/
function swsctp_change_default_email_change_from_email($email_old) { 
    $email_new = get_option( 'swsint-default-email ');
    if ( $email_new != "" ) {
        return $email_new;
    } else {
        return $email_old;	
    }
}
add_filter('wp_mail_from', 'swsctp_change_default_email_change_from_email');

/**
* Change default email from name.
* Gets custom option so "admin email name" is not used for all correspondence.
*
* @param  $fromname
* @return $name_new || $fromname
*/
function swsctp_change_default_email_change_from_name($fromname) {
    $name_new = get_option( 'swsint-default-name' );
    if ( $name_new != "" ) {
        return $name_new;
    } else {
        return $fromname;
    }
}
add_filter('wp_mail_from_name', 'swsctp_change_default_email_change_from_name');

/**
* Change Email content type to text/html to allow for HTML emails
* 
* @return string
*/
function swsctp_change_mail_content_type() {
	return "text/html";
}
add_filter ("wp_mail_content_type", "swsctp_change_mail_content_type");

/**
 * Notification Email function
 * 
 * Uses notifications.php email template for instructor class notification
 * 
 * @param String $message - Message to be included above class details
 * @param String $subject - Email Subject
 * @param String $msg_color - Color for message to be included
 * @param String $user_id - ID of user notification is to be sent to
 * @param Int $event_id - Class ID
 * @param Bool $update_trail - Whether to include audit trail update
 * @param String $inst_id - Instructor ID referred to in manager notifications (optional)
 * @param String $inst_num - Instructor Number for class (optional)
 */
function swsctp_notification_email($template, $message, $subject, $msg_color, $user_id, $event_id, $update_trail, $inst_id = false, $inst_num = false){
    ob_start();
    include(dirname( __FILE__ ) . '/emails/notifications-header.php');
    include(dirname( __FILE__ ) . "/emails/$template-notifications-body.php");
    include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
    $content = ob_get_contents();
    
    $user_data = get_userdata($user_id);
    $user_email = $user_data->first_name." ".$user_data->last_name."<".$user_data->user_email.">";
    
	
    ob_end_clean();
    wp_mail($user_email, $subject, $content);
    
    if($update_trail){
        $tribe_events_audit = get_post_meta($event_id, '_tribe_events_audit', TRUE);
        
        $timestamp = current_time('m/d/Y H:i:s', false);
        $dateTime = new DateTime(); 
        $dateTime->setTimeZone(new DateTimeZone(get_option('timezone_string'))); 
        $timestamp .= " ". $dateTime->format('T');
            
        $tribe_events_audit_addition  = "<strong>Notification Sent to: $user_data->first_name $user_data->last_name</strong><br>";
        $tribe_events_audit_addition .= "Subject: $subject<br>";
        $tribe_events_audit_addition .= "Timestamp: $timestamp<br><br>";
        $tribe_events_audit = $tribe_events_audit_addition . $tribe_events_audit;
        
        update_post_meta($event_id, '_tribe_events_audit', $tribe_events_audit);
        update_post_meta($event_id, '_tribe_events_audit_timestamp', $timestamp);
    }
}


/**
 * Filter for retreive_password_message
 * Modifies the content of the retrieve password email sent to users
 * @global $wpdb
 * @param Array $content
 * @param String $key
 * @return String
 */
function swsctp_retrieve_password_message($message, $key, $user_login, $user_data) {
        $name = get_option('blogname');
	
	ob_start();
	$message = NULL;
	$subject = "Password Reset for $name";
	
	include(dirname( __FILE__ ) . '/emails/notifications-header.php');
	?>
	
        <p style="text-align:center;">
            It likes like you want to reset your password for your <?php echo $name; ?> account.
        </p>

        <p style="text-align:center;">
            To reset your password, visit the following address, otherwise just ignore this email and nothing will happen.  
            If you did not request a password reset, please disregard this email.
        <p>
            
        <p style="text-align:center;"> 
            <?php echo wp_login_url("url") ?>?action=rp&key=<?php echo $key ?>&login=<?php echo $user_login ?>		
        </p>
	
	<?php
	
        include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
	
	$message = ob_get_contents();

	ob_end_clean();
  
	return $message;
}
add_filter ("retrieve_password_message", "swsctp_retrieve_password_message", 10, 4);


/**
 * Filter for retrieve_password_title
 * @return String
 */
function swsctp_retrieve_password_title() {
        $name = get_option('blogname');
	return "Password Reset for $name";
}
add_filter ("retrieve_password_title", "swsctp_retrieve_password_title");


/**
 * New User Notification email sent to the user, includes username and password
 * @param String $user_id
 * @param String $plaintext_pass
 */
/*
	
	<p style="text-align:center;">A very special welcome to you, //<?php echo "$user->first_name $user->last_name"; ?>.</p>
	
	<p style="text-align:center;">
            Your username is <strong>//<?php echo $user_login; ?></strong><br>
            Your password is <strong style="color:orange">//<?php echo $plaintext_pass ?></strong>
	</p>
	
	<p style="text-align:center;">
		We hope you enjoy //<?php echo $name; ?>. If you have any problems, questions, comments, 
                or suggestions, please feel free to contact us at any time.
	</p>
	
	
	<?php
	include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($user_email, $subject, $message);
}*/
function wp_new_user_notification( $user_id ) {
    
    global $wpdb, $wp_hasher;
    $user = get_userdata( $user_id );
 
    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    ob_start();
    include(dirname( __FILE__ ) . '/emails/notifications-header.php'); ?>
        
    <p style="text-align: center;">
        New user registration on your site <?php echo $blogname;?>
    </p>
    
    <p style="text-align: center;">
        Username: <?php echo $user->user_login;?><br>
        Email: <?php echo $user->user_email;?>
    </p>
    <?php
    include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
    $message = ob_get_contents();
    ob_end_clean();
    wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
    $message = NULL;
 
    // Generate something random for a password reset key.
    $key = wp_generate_password( 20, false );
 
    /** This action is documented in wp-login.php */
    do_action( 'retrieve_password_key', $user->user_login, $key );
 
    // Now insert the key, hashed, into the DB.
    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }
    $hashed = time() . ':' . $wp_hasher->HashPassword( $key );
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );
 
    ob_start();
    include(dirname( __FILE__ ) . '/emails/notifications-header.php'); ?>
        
    <p style="text-align: center;">
        You have just registered an account for <?php echo $blogname;?>
    </p>
    
    <p style="text-align: center;">
        Username: <?php echo $user->user_login;?>
    </p>
    
    <p style="text-align: center;">
        To set your password, visit the following address:<br>
        <?php 
            $site_url = get_site_url();
            $login_url = "$site_url/wp-login.php?action=rp&key=$key&login=".rawurlencode($user->user_login); 
        ?>
        <a href="<?php echo $login_url; ?>"><?php echo $login_url; ?></a>
    </p>
    <?php
    include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
    $message = ob_get_contents();
    ob_end_clean();
    
 
    wp_mail($user->user_email, sprintf(__('[%s] Your Username and Password Info'), $blogname), $message);
}




/**
 * Filter for User Notification email sent to the user upon password change
 * @param Obj $user
 */
function swsctp_password_change_notification($pass_change_mail, $user, $userdata) {

	$user_login = stripslashes($userdata['user_login']);
        $user_name = stripslashes($user['first_name']);
        $name = get_option('blogname');
	
	$subject = "Password changed for ".$user_login."!";
	
	ob_start();

	include(dirname( __FILE__ ) . '/emails/notifications-header.php');
	
	?>
	
	<p><?php echo $user_name; ?>,</p>
	
	<p style="text-align:center;">
            Your password has just been reset for your <?php echo $name; ?> account.  <?php if(get_option('admin_email')){ ?>
            If you did not initiate this change, please contact our administrator at: <?php echo get_option('admin_email'); } ?>
	</p>
        
	<?php
	include(dirname( __FILE__ ) . '/emails/notifications-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();
        
        $pass_change_mail['subject'] = $subject;
        $pass_change_mail[ 'message' ] = $message;
	return $pass_change_mail;
}
add_filter('password_change_email', 'swsctp_password_change_notification', 10, 3);

//
///**
// * Function for new email heading for all woocommerce emails
// * Applied with filters defined below
// * 
// * @param String $heading
// * @param Int $order
// * @return String
// */
//function swsctp_woocommerce_heading($heading, $order){
//    ob_start();
//    include(dirname( __FILE__ ) . '/emails/notifications-header.php');
//    $message = ob_get_contents();
//    ob_end_clean();
//    return $message;
//}
//add_filter('woocommerce_email_heading_new_order', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_processing_order', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_completed_order', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_invoice', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_note', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_low_stock', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_no_stock', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_backorder', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_new_account', 'swsctp_woocommerce_heading', 1, 2);
//add_filter('woocommerce_email_heading_customer_invoice_paid', 'swsctp_woocommerce_heading', 1, 2);
//
//
//
