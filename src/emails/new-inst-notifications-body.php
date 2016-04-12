
                                    
                                    <?php
                                    
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
                                    <?php } ?>
                                    <h2 class="tribe-events-single-event-title summary entry-title" style="text-transform:uppercase;margin-bottom:5px;">
                                        <?php echo get_the_title( $event_id ); ?>
                                    </h2>
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
                                    $gcal = tribe_get_gcal_link($event_id); ?>
                                    
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
                                                            <?php echo tribe_get_venue($event_id); ?><br>
                                                            <?php echo tribe_get_full_address($event_id); ?>
                                                        </span>
                                                    </td>
                                                    <td class="class-details" valign="top" align="left" width="50%" style="padding: 0; width:50%; margin:0 !important; border-top:1px solid #ddd !important;">
                                                        <h6 style="color:#909090 !important; margin:0 0 10px 0; font-family: 'Helvetica Neue', Helvetica, sans-serif; text-transform:uppercase; font-size:13px; font-weight:700 !important; margin-top:20px!important;"><?php esc_html_e( 'Phone', 'event-tickets' ); ?></h6>
                                                        <span style="color:#0a0a0e !important; font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:15px;"><?php echo $venue_phone; ?></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <?php $venue_address = tribe_get_full_address($event_id); ?>
                                        <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-bottom">
                                            <?php $map = "http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyBWJnZ6_W8nuF4gTP0Q104-Ubo46uaJEZ4&center=".urlencode(strip_tags($venue_address))."&zoom=14&size=600x200&markers=color:red%7C".urlencode(strip_tags($venue_address));?>
                                            <a href="<?php tribe_get_map_link($event_id); ?>" style="max-width: 100%;"><img src="<?php echo $map; ?>" alt="<?php echo tribe_get_venue($event_id); ?>" style="margin:auto; width:100%;"></a>
                                        </div>
                                    </div><!-- #tribe-events-content -->



