                                    <?php  
                                    $inst_data = get_userdata($inst_id); 
                                    
                                    $ip = get_post_meta($event_id, "_tribe_events_inst".$inst_num."_sig_ip", true);
                                    $date = get_post_meta($event_id, "_tribe_events_inst".$inst_num."_sig_date", true);
                                    $decline_rsn = get_post_meta($event_id, "_tribe_events_inst".$inst_num."_decline_rsn", true);
                                    $sig = get_post_meta($event_id, "_tribe_events_inst".$inst_num."_sig", true);
                                    
                                    ?>
                                    <h3 id="notification" style="width: 80%; margin:auto; text-align: center; <?php if(isset($msg_color)){ ?> color: dark<?php echo $msg_color; ?>; <?php } ?>">
                                        <?php echo "$inst_data->first_name $inst_data->last_name has $message the assignment for class #$event_id";?>.
                                    </h3>
                                    
                                    <h2 class="tribe-events-single-event-title summary entry-title" style="text-transform:uppercase;margin-bottom:5px;">
                                    <?php echo get_the_title( $event_id ); ?>
                                    </h2>
                                    <div class="tribe-events-schedule updated published tribe-clearfix" style="display:inline-flex;">
                                            <?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
                                    </div>

                                    <div class="tribe-events-single-section tribe-events-event-meta primary tribe-events-schedule updated published tribe-clearfix">
                                        <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                                            <tr>
                                                <td class="class-details" id="inst-details-1" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                    <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Timestamp', 'event-tickets' ); ?></h6>
                                                    <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $date;?></span>
                                                </td>
                                                <td class="class-details" id="inst-details-2" valign="top" align="left" width="150" style="padding: 0; width:150px; margin:0 !important; border-top:1px solid #ddd !important;">
                                                    <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'IP Address', 'event-tickets' ); ?></h6>
                                                    <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"> <?php echo $ip?> </span>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-bottom">
                                            <?php if($message == "accepted"){ ?>
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:25px;">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="100%" style="padding: 0; width:100%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Signature', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $sig; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php } elseif($message == "declined") { ?>
                                            <table class="class-details" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:25px;">
                                                <tr>
                                                    <td class="class-details" valign="top" align="left" width="100%" style="padding: 0; width:100%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Decline Reason', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $decline_rsn; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    



