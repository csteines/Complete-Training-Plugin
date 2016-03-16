<?php

/* 
 * shortcode-functions.php
 * 
 * This file contains the shortcode definitions used throughout the plugin.
 * 
 */

/**
 * Instructor Name [instructor_name] 
 * @return [user-firstname] [user-lastname]
 */
function swsctp_instructor_name(){
    $current_user = wp_get_current_user();
    if($current_user){
        return $current_user->user_firstname. " ". $current_user->user_lastname;
    }
    else{
        return "[instructor_name]";
    }
}
add_shortcode('instructor_name', 'swsctp_instructor_name');



/**
 * Course Start Date & Time [start_date_time]
 * @return MM/DD/YYYY @ HH:MM
 */
function swsctp_course_date_time(){
    if(tribe_get_start_date()){
        return tribe_get_start_date();
    }
    else{
        return "[class_start_date_time]";
    }
}
add_shortcode('start_date_time', 'swsctp_course_date_time');



/**
 * Full Course Location (w/ address) [full_location]
 * @return  [Venue Name]
 *          [Venue Address]
 */
function swsctp_full_course_location(){
    $venue = tribe_get_venue_details();
    if($venue){
        $location = $venue['name']. "<br>". $venue['address'];
        return $location;
    }
    else{
        return "[full_class_location]";
    }
}
add_shortcode('full_location', 'swsctp_full_course_location');



/**
 * Course Location [location]
 * @return  [Venue Name]
 */
function swsctp_course_location(){
    $venue = tribe_get_venue_details();
    if($venue){
        $location = $venue['name'];
        return $location;
    }
    else{
        return "[class_location]";
    }
}
add_shortcode('location', 'swsctp_course_location');



/**
 * Instructor Rate [instructor_rate]
 * @return $[rate] per [unit]
 */
function swsctp_instructor_rate(){                
    $tribe_events_inst_rate_unit = get_post_meta($post->ID, '_tribe_events_inst_rate_unit', TRUE);
    $tribe_events_inst_rate = get_post_meta($post->ID, '_tribe_events_inst_rate', TRUE);
    if($tribe_events_inst_rate){
        $rate = "$".$tribe_events_inst_rate." per ".$tribe_events_inst_rate_unit;
        return $rate;
    }
    else{
        return "[instructor_rate]";
    }
}
add_shortcode('instructor_rate', 'swsctp_instructor_rate');



/**
 * Signing Date [sign_date]
 * @return [Date Signed] -or- [Current Date if proper user] -or- [Blank Space]
 */
function swsctp_signing_date(){
    $current_user = wp_get_current_user();
    $tribe_events_inst1 = get_post_meta($post->ID, '_tribe_events_inst1', TRUE);
    $tribe_events_inst2 = get_post_meta($post->ID, '_tribe_events_inst2', TRUE);
    $tribe_events_inst3 = get_post_meta($post->ID, '_tribe_events_inst3', TRUE);
    
    $tribe_events_inst1_sig_date = get_post_meta($post->ID, '_tribe_events_inst1_sig_date', TRUE);
    $tribe_events_inst2_sig_date = get_post_meta($post->ID, '_tribe_events_inst2_sig_date', TRUE);
    $tribe_events_inst3_sig_date = get_post_meta($post->ID, '_tribe_events_inst3_sig_date', TRUE);
    
    if($current_user->ID == $tribe_events_inst1){
        if($tribe_events_inst1_sig_date){
            $date = date('dS', $tribe_events_inst1_sig_date);
            return $date;
        }
        else{
            return date('dS', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst2){
        if($tribe_events_inst2_sig_date){
            $date = date('dS', $tribe_events_inst2_sig_date);
            return $date;
        }
        else{
            return date('dS', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst3){
        if($tribe_events_inst3_sig_date){
            $date = date('dS', $tribe_events_inst3_sig_date);
            return $date;
        }
        else{
            return date('dS', time());
        }
    }
    else{
        return date('DS', time());
    }
}
add_shortcode('sign_date', 'swsctp_signing_date');



/**
 * Signing Month [sign_month]
 * @return [Month Signed] -or- [Current Month if proper user] -or- [Blank Space]
 */
function swsctp_signing_month(){
    $current_user = wp_get_current_user();
    $tribe_events_inst1 = get_post_meta($post->ID, '_tribe_events_inst1', TRUE);
    $tribe_events_inst2 = get_post_meta($post->ID, '_tribe_events_inst2', TRUE);
    $tribe_events_inst3 = get_post_meta($post->ID, '_tribe_events_inst3', TRUE);
    
    $tribe_events_inst1_sig_date = get_post_meta($post->ID, '_tribe_events_inst1_sig_date', TRUE);
    $tribe_events_inst2_sig_date = get_post_meta($post->ID, '_tribe_events_inst2_sig_date', TRUE);
    $tribe_events_inst3_sig_date = get_post_meta($post->ID, '_tribe_events_inst3_sig_date', TRUE);
    
    if($current_user->ID == $tribe_events_inst1){
        if($tribe_events_inst1_sig_date){
            $date = date('F', $tribe_events_inst1_sig_date);
            return $date;
        }
        else{
            return date('F', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst2){
        if($tribe_events_inst2_sig_date){
            $date = date('F', $tribe_events_inst2_sig_date);
            return $date;
        }
        else{
            return date('F', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst3){
        if($tribe_events_inst3_sig_date){
            $date = date('F', $tribe_events_inst3_sig_date);
            return $date;
        }
        else{
            return date('F', time());
        }
    }
    else{
        return "______";
    }
}
add_shortcode('sign_month', 'swsctp_signing_month');



/**
 * Signing Date [sign_year]
 * @return [Year Signed] -or- [Current Year if proper user] -or- [Blank Space]
 */
function swsctp_signing_year(){
    $current_user = wp_get_current_user();
    $tribe_events_inst1 = get_post_meta($post->ID, '_tribe_events_inst1', TRUE);
    $tribe_events_inst2 = get_post_meta($post->ID, '_tribe_events_inst2', TRUE);
    $tribe_events_inst3 = get_post_meta($post->ID, '_tribe_events_inst3', TRUE);
    
    $tribe_events_inst1_sig_date = get_post_meta($post->ID, '_tribe_events_inst1_sig_date', TRUE);
    $tribe_events_inst2_sig_date = get_post_meta($post->ID, '_tribe_events_inst2_sig_date', TRUE);
    $tribe_events_inst3_sig_date = get_post_meta($post->ID, '_tribe_events_inst3_sig_date', TRUE);
    
    if($current_user->ID == $tribe_events_inst1){
        if($tribe_events_inst1_sig_date){
            $date = date('Y', $tribe_events_inst1_sig_date);
            return $date;
        }
        else{
            return date('Y', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst2){
        if($tribe_events_inst2_sig_date){
            $date = date('Y', $tribe_events_inst2_sig_date);
            return $date;
        }
        else{
            return date('Y', time());
        }
    }
    else if($current_user->ID == $tribe_events_inst3){
        if($tribe_events_inst3_sig_date){
            $date = date('Y', $tribe_events_inst3_sig_date);
            return $date;
        }
        else{
            return date('Y', time());
        }
    }
    else{
        return "______";
    }
}
add_shortcode('sign_year', 'swsctp_signing_year');



/**
 * Class Name [class_name]
 * @return class title
 */
function swsctp_class_name(){
    $title = tribe_get_events_title(false);
    error_log($title);
    if($title && $title !== "Upcoming Events"){
        return $title;
    }
    else{
        return "[class_name]";
    }
}
add_shortcode('class_name', 'swsctp_class_name');



/**
 * Instructor Address [instructor_address]
 * @return [address 1]
 *         [city], [state] [zip]
 */
function swsctp_instructor_address(){
    $current_user = wp_get_current_user();
    if($current_user){
        $user_meta = get_user_meta($current_user->ID);
        $meta = array_map( function( $a ){ return $a[0]; }, $user_meta);
        $address  = $meta['billing_address_1'].'<br>'.$meta['billing_city'].", ".$meta['billing_state']." ".$meta['billing_postcode'];
        error_log(print_R($user_meta, true));
        return $address;
    }
    else{
        return "[instructor_address]";
    }
}
add_shortcode('instructor_address', 'swsctp_instructor_address');



function swsctp_echo_cont_agrmnt(){
    $swsctp_options = get_option( 'swsctp_options' );
    echo do_shortcode($swsctp_options['cont_agrmnt']);
}
add_shortcode('contractor_agreement', 'swsctp_echo_cont_agrmnt');


