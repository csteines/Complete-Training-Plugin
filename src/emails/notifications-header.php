<?php
/**
 * Notifications Email Template
 *
 * @package TribeEventsCalendar
 * 
 * SWSCTP_VERSION = 0.0.1 
 */

$swsctp_options = get_option( 'swsctp_options' );
$header_img[0] = esc_url( $swsctp_options['logo'] );
//list($width, $height) = getimagesize( $header_img[0] );
//$header_img[1] = $width;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php esc_html_e( $subject, 'event-tickets' ); ?></title>
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
                                            //$header_width = esc_attr( $header_img[1] );
                                            //if ( $header_width > 580 ) {
                                                    //$header_width = 580;
                                                    $header_width = 300;
                                            //}
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

                                    if(isset($message) && !$inst_id){ ?>
                                    <!--  Notifications  -->
                                    <h3 id="notification" style="width: 80%; margin:auto; text-align: center; <?php if(isset($msg_color)){ ?> color: dark<?php echo $msg_color; ?>; <?php } ?>"><?php echo $message; ?></h3>
                                    <?php } ?>