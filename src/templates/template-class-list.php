  <?php 
	/**
	 * Template Name: Instructor Class List
         * 
         * This is the template for the Complete Training Plugin - Instructor Class List page
         * This page is accessible via the slug /instructor-class-list
         * 
	**/

        get_header();

        if(is_user_logged_in() && (current_user_can('instructor') || current_user_can('editor') || current_user_can('administrator'))){
            $curuser = wp_get_current_user();
            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
            error_log("paged: $paged");
            $args = array(
                    'post_type' => 'tribe_events',
                    'meta_query' => array(
                            'relation' => 'OR',
                            array('key' => '_tribe_events_inst1', 'value' => $curuser->ID),
                            array('key' => '_tribe_events_inst2', 'value' => $curuser->ID),
                            array('key' => '_tribe_events_inst3', 'value' => $curuser->ID)
                    ),
                    'meta_key' => '_EventStartDate',
                    'orderby'  => 'meta_value',
                    'order' => 'ASC',
                    'posts_per_page' => 5,
                    'paged' => $paged
            );

            $catargs = array(
                    'echo' => false,
                    'before' => '',
                    'sep' => ', ',
                    'after' => '',
                    'label' => '',
                    'label_before' => '',
                    'label_after' => '',
                    'wrap_before' => '',
                    'wrap_after' => ''
            );

            //Execute WP_query to get all events that have not yet passed
            $the_query = new WP_Query( $args );

            // The Loop
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $postid = $the_query->post->ID;

                    //Get Saved Instructors
                    $tribe_events_inst1 = get_post_meta($postid, '_tribe_events_inst1', TRUE);
                    $tribe_events_inst2 = get_post_meta($postid, '_tribe_events_inst2', TRUE);
                    $tribe_events_inst3 = get_post_meta($postid, '_tribe_events_inst3', TRUE);

                    //Get Saved Instructor Statuses
                    $tribe_events_inst1_stat = get_post_meta($postid, '_tribe_events_inst1_stat', TRUE);
                    $tribe_events_inst2_stat = get_post_meta($postid, '_tribe_events_inst2_stat', TRUE);
                    $tribe_events_inst3_stat = get_post_meta($postid, '_tribe_events_inst3_stat', TRUE);

                    $tribe_events_status = get_post_meta($postid, '_tribe_events_status', TRUE);
                    $event_url = tribe_get_event_link();
                    $event_url .= "inst-view";

                    if($tribe_events_inst1 == $curuser->ID || $tribe_events_inst2 == $curuser->ID || $tribe_events_inst3 == $curuser->ID){
                        if($count == 0){
                            echo "<h3>Classes Assigned to: ". __($curuser->user_firstname, 'avia_framework') ." ". __($curuser->user_lastname, 'avia_framework')."</h3>";
                            echo "<table class='class_list_table' style='width:100%;'><tr><th>Class Name</th><th>Course</th><th>Start Date/Time</th><th>Location</th><th>Status</th><th>Additional Info/Sign</th></tr>";
                        }
                        error_log($tribe_events_inst1.", ".$tribe_events_inst2.", ".$tribe_events_inst3.", ".$curuser->ID);


                        if($curuser->ID == $tribe_events_inst1){ $my_status = $tribe_events_inst1_stat; }
                        else if($curuser->ID == $tribe_events_inst2){ $my_status = $tribe_events_inst2_stat; }
                        else if($curuser->ID == $tribe_events_inst3){ $my_status = $tribe_events_inst3_stat; }

                    ?>
                        <tr class="list-<?php echo $tribe_events_status;?>">
                                <td><?php the_title(); ?></td>
                                <td><?php echo str_replace( 'http//', '//', str_replace( ':', '', tribe_get_event_categories($postid, $catargs)));?></td>
                                <td><?php echo tribe_get_start_date($postid, true);?></td>
                                <td><a href="<?php echo tribe_get_map_link($postid);?>" target="_blank"><?php echo tribe_get_venue($postid);?><br/><?php echo tribe_get_full_address($postid, false);?></a></td>
                                <td>
                                    <?php echo ucwords($tribe_events_status);
                                    if ($tribe_events_status != "cancelled") { ?><br>
                                    <?php if($my_status == "pending"){ echo "<span class='$my_status'>Pending Acceptance</span>"; }
                                          else { echo "<span class='$my_status'>" . ucwords($my_status) . "</span>"; } 
                                    }?>
                                </td>
                                <td><a href="<?php echo esc_url($event_url);?>"><?php if($my_status == "pending" && $tribe_events_status != "cancelled"){echo "Info &amp; Sign";}else{ echo "Info";}?></a></td>
                        </tr>
                    <?php 
                    $count = $count + 1;
                    }
                }?> 
            </table> 
                
            <?php if ($the_query->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
                <nav class="prev-next-posts">
                    <div class="prev-posts-link">
                        <?php echo get_previous_posts_link( '&laquo; Previous Page' ); // display newer posts link ?>
                    </div>
                    <div class="next-posts-link">
                        <?php echo get_next_posts_link( 'Next Page &raquo;', $the_query->max_num_pages ); // display older posts link ?>
                    </div>
                </nav>
            <?php } 
            wp_reset_postdata();

            } else { ?>
            <h3>You have no classes assigned.</h3>
            <?php }
        }else{ ?>
            <h3>You are accessing an employee only page.</h3>  
            <p>Please login, or <a href="">click here</a> to view a complete calendar of courses</p> 
            <?php $login_form = wp_login_form( array('echo' => false));
            echo $login_form;?>
            <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="Forgot Your Password?">Forgot Your Password?</a>
        <?php } ?>

	</div><!--end container-->

<?php get_footer(); ?>