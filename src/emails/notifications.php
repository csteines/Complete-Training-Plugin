<?php
/**
 * Notifications Email Template
 *
 * @package TribeEventsCalendar
 * 
 * SWSCTP_VERSION = 0.0.1 
 */


    //Get Saved Instructors
$tribe_events_inst1 = get_post_meta($event_id, '_tribe_events_inst1', TRUE);
$tribe_events_inst2 = get_post_meta($event_id, '_tribe_events_inst2', TRUE);
$tribe_events_inst3 = get_post_meta($event_id, '_tribe_events_inst3', TRUE);

//Get Saved Instructor Statuses
$tribe_events_inst1_stat = get_post_meta($event_id, '_tribe_events_inst1_stat', TRUE);
$tribe_events_inst2_stat = get_post_meta($event_id, '_tribe_events_inst2_stat', TRUE);
$tribe_events_inst3_stat = get_post_meta($event_id, '_tribe_events_inst3_stat', TRUE);

//Get all other saved class details metabox items
$tribe_events_inst_rate_unit = get_post_meta($event_id, '_tribe_events_inst_rate_unit', TRUE);
$tribe_events_inst_rate = get_post_meta($event_id, '_tribe_events_inst_rate', TRUE);
$tribe_events_inst_notes = get_post_meta($event_id, '_tribe_events_inst_notes', TRUE);
$tribe_events_equip_needed = get_post_meta($event_id, '_tribe_events_equip_needed', TRUE);
$tribe_events_status = get_post_meta($event_id, '_tribe_events_status', TRUE);

$swsctp_options = get_option( 'swsctp_options' );
$header_img[0] = $swsctp_options['logo'];
list($width, $height) = getimagesize( $header_img[0]);
$header_img[1] = $width;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php esc_html_e( '$subject', 'event-tickets' ); ?></title>
	<meta name="viewport" content="width=device-width" />
	<style type="text/css">
		h1, h2, h3, h4, h5, h6 {
			color : #0a0a0e;
		}

		a, img {
			border  : 0;
			outline : 0;
		}

		#outlook a {
			padding : 0;
		}

		.ReadMsgBody, .ExternalClass {
			width : 100%
		}

		.yshortcuts, a .yshortcuts, a .yshortcuts:hover, a .yshortcuts:active, a .yshortcuts:focus {
			background-color : transparent !important;
			border           : none !important;
			color            : inherit !important;
		}

		body {
			background  : #ffffff;
			min-height  : 1000px;
			font-family : sans-serif;
			font-size   : 14px;
		}

		.appleLinks a {
			color           : #006caa;
			text-decoration : underline;
		}

		@media only screen and (max-width: 480px) {
			body, table, td, p, a, li, blockquote {
				-webkit-text-size-adjust : none !important;
			}

			body {
				width     : 100% !important;
				min-width : 100% !important;
			}

			body[yahoo] h2 {
				line-height : 120% !important;
				font-size   : 28px !important;
				margin      : 15px 0 10px 0 !important;
			}

			table.content,
			table.wrapper,
			table.inner-wrapper {
				width : 100% !important;
			}

			table.ticket-content {
				width   : 90% !important;
				padding : 20px 0 !important;
			}

			table.ticket-details {
				position       : relative;
				padding-bottom : 100px !important;
			}

			table.ticket-break {
				width : 100% !important;
			}

			td.wrapper {
				width : 100% !important;
			}

			td.ticket-content {
				width : 100% !important;
			}

			td.ticket-image img {
				max-width : 100% !important;
				width     : 100% !important;
				height    : auto !important;
			}

			td.ticket-details, td.class-details {
				width         : 33% !important;
				padding-right : 10px !important;
				border-top    : 1px solid #ddd !important;
			}

			td.ticket-details h6, td.class-details h6 {
				margin-top : 20px !important;
			}

			td.ticket-details.new-row, td.class-details.new-row {
				width      : 50% !important;
				height     : 80px !important;
				border-top : 0 !important;
				position   : absolute !important;
				bottom     : 0 !important;
				display    : block !important;
			}

			td.ticket-details.new-left-row, td.class-details.new-left-row {
				left : 0 !important;
			}

			td.ticket-details.new-right-row, td.class-details.new-right-row {
				right : 0 !important;
			}

			table.ticket-venue {
				position       : relative !important;
				width          : 100% !important;
				padding-bottom : 150px !important;
			}

			td.ticket-venue,
			td.ticket-organizer,
			td.ticket-qr {
				width      : 100% !important;
				border-top : 1px solid #ddd !important;
			}

			td.ticket-venue h6,
			td.ticket-organizer h6 {
				margin-top : 20px !important;
			}

			td.ticket-qr {
				text-align : left !important
			}

			td.ticket-qr img {
				float      : none !important;
				margin-top : 20px !important
			}

			td.ticket-organizer,
			td.ticket-qr {
				position : absolute;
				display  : block;
				left     : 0;
				bottom   : 0;
			}

			td.ticket-organizer {
				bottom : 0px;
				height : 100px !important;
			}

			td.ticket-venue-child {
				width : 50% !important;
			}

			table.venue-details {
				position : relative !important;
				width    : 100% !important;
			}

			a[href^="tel"], a[href^="sms"] {
				text-decoration : none;
				color           : black;
				pointer-events  : none;
				cursor          : default;
			}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
				text-decoration : default;
				color           : #006caa !important;
				pointer-events  : auto;
				cursor          : default;
			}
                        
                        .hr-divider{
                                display: none;
                        }
                        
                        #inst-details-3{
                                width: 100%;
                        }
                        
                        #inst-details-1, #inst-details-2 {
                                width: 50%;
                        }
		}

		@media only screen and (max-width: 320px) {
			td.ticket-venue h6,
			td.ticket-organizer h6,
			td.ticket-details h6,
                        td.class-details h6{
				font-size : 12px !important;
			}
		}


		<?php do_action( 'tribe_tickets_ticket_email_styles' );?>

	</style>
</head>
<body yahoo="fix" alink="#006caa" link="#006caa" text="#000000" bgcolor="#ffffff" style="width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0 auto; padding:20px 0 0 0; background:#ffffff; min-height:1000px;">
    <div style="margin:0; padding:0; width:100% !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:14px; line-height:145%; text-align:left;">
        <center>
            <table class="content" align="center" width="620" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" style="margin:0 auto; padding:0;<?php echo $break; ?>">
                <tr>
                    <td align="center" valign="top" class="wrapper" width="620">
                        <table class="inner-wrapper" border="0" cellpadding="0" cellspacing="0" width="620" bgcolor="#f7f7f7" style="margin:0 auto !important; width:620px; padding:0;">
                            <tr>
                                <td valign="top" class="ticket-content" align="left" width="580" border="0" cellpadding="20" cellspacing="0" style="padding:20px; background:#f7f7f7;">

                                    <?php								
                                    if ( ! empty( $header_img ) ) {
                                            $header_width = esc_attr( $header_img[1] );
                                            if ( $header_width > 580 ) {
                                                    $header_width = 580;
                                            }
                                            ?>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                            <td class="ticket-image" valign="top" align="left" width="100%" style="padding-bottom:15px !important;">
                                                                    <img src="<?php echo esc_attr( $header_img[0] ); ?>" width="<?php echo esc_attr( $header_width ); ?>" alt="<?php echo esc_attr( $event->post_title ); ?>" style="border:0; outline:none; height:auto; max-width:100%; display:block; margin: auto;" />
                                                            </td>
                                                    </tr>
                                            </table>
                                            <?php
                                    }

                                    if(isset($message)){ ?>
                                    <!--  Notifications  -->
                                    <h3 id="notification" style="width: 80%; margin:auto; text-align: center; <?php if(isset($msg_color)){ ?> color: dark<?php echo $msg_color; ?>; <?php } ?>"><?php echo $message; ?></h3>
                                    <?php }
                                    
                                    //Check if signature is required by current user
                                    if((    $user_id == $tribe_events_inst1 && $tribe_events_inst1_stat == "pending" ) ||
                                       (    $user_id == $tribe_events_inst2 && $tribe_events_inst2_stat == "pending" ) ||
                                       (    $user_id == $tribe_events_inst3 && $tribe_events_inst3_stat == "pending" )){
                                        $inst_sign_needed = true;
                                    }
                                    
                                    if($inst_sign_needed){ ?>
                                    <div id="inst-buttons" style="padding:30px;text-align: center;">
                                        <a href="<?php echo get_permalink($event_id); ?>?inst_view=1" target="_blank" style="padding:10px; <?php if(isset($msg_color)){ ?>background-color:dark<?php echo $msg_color;?>;<?php } else{ ?>background-color:gray; <?php } ?> color: white; border-radius: 4px; text-decoration: none;">Sign &amp; Accept / Decline</a>
                                    </div>
                                    <?php }



                                    the_title( '<h2 class="tribe-events-single-event-title summary entry-title" style="text-transform:uppercase;margin-bottom:5px;">', '</h2>' ); ?>
                                    <h3 class="tribe-events-single-event-title summary entry-title" style="text-transform:uppercase;margin-top:0px;">Instructor Details</h3>

                                    <div class="tribe-events-schedule updated published tribe-clearfix" style="display:inline-flex;">
                                            <?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
                                    </div>
                                    <?php
                                    //Change statuses to Uppercase Words
                                    $status = ucwords($tribe_events_status);
                                    $inst1stat = ucwords($tribe_events_inst1_stat);
                                    $inst2stat = ucwords($tribe_events_inst2_stat);
                                    $inst3stat = ucwords($tribe_events_inst3_stat);

                                    //Get User Data for Instructors
                                    $userdata1 = get_userdata( $tribe_events_inst1 );
                                    $userdata2 = get_userdata( $tribe_events_inst2 );
                                    $userdata3 = get_userdata( $tribe_events_inst3 );

                                    $iru = " per " . ucwords($tribe_events_inst_rate_unit);

                                     

                                    //Get Venue Information
                                    if ( function_exists( 'tribe_get_venue_id' ) ) {
                                        $venue_id = tribe_get_venue_id( $event_id );
                                        if ( ! empty( $venue_id ) ) {
                                                $venue = get_post( $venue_id );
                                        }

                                        $venue_label = tribe_get_venue_label_singular();

                                        $venue_name = $venue_phone = $venue_address = '';
                                        if ( ! empty( $venue ) ) {
                                            $venue_phone   = get_post_meta( $venue_id, '_VenuePhone', true );
                                        }
                                    }
                                    
                                    //Get Course(s) list
                                    $classes = get_the_terms( $event_id, 'tribe_events_cat' );
                                    if ( $classes && ! is_wp_error( $classes ) ){ 

                                        $draught_links = array();
                                        foreach ( $classes as $class ) { $class_links[] = $class->name; }

                                        $course_list = join( ", ", $class_links );
                                    }
                                    ?>


                                    <?php //do_action( 'tribe_events_single_event_after_the_content' ); 
                                    $gcal = tribe_get_gcal_link(); ?>
                                    
                                    <div style="display:inline-flex">
                                        <div id="inst-buttons" style="padding:10px;">
                                            <a href="<?php echo $gcal; ?>" target="_blank" style="padding:10px; background:gray; color: white; border-radius: 4px; text-decoration: none;">+Google Calendar</a>
                                        </div>

                                        <div id="inst-buttons" style="padding:10px;">
                                            <a href="<?php echo get_permalink($event_id); ?>?ical=1" target="_blank" style="padding:10px; background:gray; color: white; border-radius: 4px; text-decoration: none;">+iCal Export</a>
                                        </div>
                                    </div>

                                    <!-- Instructor Details -->
                                    <div class="tribe-events-single-section tribe-events-event-meta primary tribe-events-schedule updated published tribe-clearfix">
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-header">
                                            <h3 class="tribe-events-single-section-title" style="text-transform: uppercase;"> Instructor Details </h3>
                                        </div>
                                        <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                                            <tr>
                                                    <td class="class-details" id="inst-details-1" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Class Status', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $status;?></span>
                                                    </td>
                                                    <?php if($tribe_events_inst_rate){ ?>
                                                    <td class="class-details" id="inst-details-2" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Instructor Rate', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"> $<?php echo $tribe_events_inst_rate; echo $iru;?> </span>
                                                    </td>
                                                    <?php } ?>
                                                    <td class="class-details" id="inst-details-3" valign="top" align="left" width="150" style="padding: 0 !important; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Instructors', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;">
                                                            <?php if(!$tribe_events_inst1){?>
                                                            No Instructors Assigned
                                                            <?php } else{ ?>
                                                            <div class="tribe_inst"><?php echo $userdata1->first_name ." ". $userdata1->last_name;?></div>
                                                            <?php if($tribe_events_inst2){ ?>
                                                            <div class="tribe_inst"><?php echo $userdata2->first_name ." ". $userdata2->last_name;?></div>
                                                            <?php } 
                                                            if($tribe_events_inst3){ ?>
                                                            <div class="tribe_inst"><?php echo $userdata3->first_name ." ". $userdata3->last_name;?></div>
                                                            <?php }
                                                            } ?>
                                                        </span>
                                                    </td>
                                            </tr>
                                        </table>
                                        
                                        <?php if($tribe_events_equip_needed || $tribe_events_inst_notes){ ?>
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-bottom">
                                            <?php if($tribe_events_inst_notes){ ?>
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:25px;">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="100%" style="padding: 0; width:100%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Instructor Notes', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $tribe_events_inst_notes; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php }
                                            if($tribe_events_equip_needed){ ?>
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:25px;">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="100%" style="padding: 0; width:100%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Equipment Needed', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $tribe_events_equip_needed; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <!--<hr class="hr-divider" style="width:98%; margin: 15px auto; border:none; border-top:dotted #DADADA 1px; " />-->
                                    <div class="tribe-events-single-section tribe-events-event-meta primary tribe-events-schedule updated published tribe-clearfix">
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-header">
                                            <h3 class="tribe-events-single-section-title" style="text-transform: uppercase;"> Class Details </h3>
                                        </div>
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-left">
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Date', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo tribe_get_start_date($event_id, false, 'l, F j'); ?></span>
                                                    </td>
                                                    <td class="class-details" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Time', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo tribe_get_start_time($event_id, 'g:i A' ); ?> - <?php echo tribe_get_end_time($event_id, 'g:i A' ); ?></span>
                                                    </td>
                                                    <td class="class-details" valign="top" align="left" width="150" style="padding: 0 !important; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Student Cost', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo tribe_get_cost($event_id, true); ?></span>
                                                    </td>
                                                    <td class="class-details" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Course', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $course_list; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details clearfix" id="tribe-events-inst-meta-right" style="margin: 25px 0px;">
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top: 25px;">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="50%" style="padding: 0; width:50%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Venue', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;">
                                                            <?php echo tribe_get_venue(); ?><br>
                                                            <?php echo tribe_get_full_address(); ?>
                                                        </span>
                                                    </td>
                                                    <td class="class-details" valign="top" align="left" width="50%" style="padding: 0; width:50%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Phone', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $venue_phone; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <?php $venue_address = tribe_get_full_address(); ?>
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-bottom">
                                            <?php $map = "http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyBWJnZ6_W8nuF4gTP0Q104-Ubo46uaJEZ4&center=".urlencode(strip_tags($venue_address))."&zoom=14&size=600x200&markers=color:red%7C".urlencode(strip_tags($venue_address));?>
                                            <a href="<?php tribe_get_map_link($post_id); ?>" style="max-width: 100%;"><img src="<?php echo $map; ?>" alt="<?php echo tribe_get_venue(); ?>" style="margin:auto; width:100%;"></a>
                                        </div>
                                    </div><!-- #tribe-events-content -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </center>
    </div>
</body>


