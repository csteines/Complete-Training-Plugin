<?php
/* column-mods.php
 * 
 * Function for Jigsaw Column Modifications for Tribe_Events Post Type Admin Page
 * 
 * This file provides uses the Jigsaw plugin class for removing and adding specific columns to the 
 * admin page listing all Tribe_Events Post Type posts.  This allows the quick viewing of key
 * information required by site/company administrators/managers.
 * 
 */

function swsctp_class_column_mod(){
	if ( class_exists('Jigsaw') ) {
		Jigsaw::add_column('tribe_events', 'Instructor(s)', function($post_id){
			$tribe_events_inst1 = get_post_meta($post_id, '_tribe_events_inst1', TRUE);
                        $tribe_events_inst2 = get_post_meta($post_id, '_tribe_events_inst2', TRUE);
                        $tribe_events_inst3 = get_post_meta($post_id, '_tribe_events_inst3', TRUE);
                        
			$tribe_events_inst1_stat = get_post_meta($post_id, '_tribe_events_inst1_stat', TRUE);
                        $tribe_events_inst2_stat = get_post_meta($post_id, '_tribe_events_inst2_stat', TRUE);
                        $tribe_events_inst3_stat = get_post_meta($post_id, '_tribe_events_inst3_stat', TRUE);
        
			$user_data1 = get_userdata($tribe_events_inst1);
			$user_data2 = get_userdata($tribe_events_inst2);
			$user_data3 = get_userdata($tribe_events_inst3);
                        
                        if($user_data1->last_name !== null){
                            echo( "<span class='tribe_inst $tribe_events_inst1_stat'>" . $user_data1->last_name . ", " . $user_data1->first_name . "</span>" );
                            
                            if($user_data2->last_name !== null){
                                echo( "<br><span class='tribe_inst $tribe_events_inst2_stat'>" . $user_data2->last_name . ", " . $user_data2->first_name . "</span>" );
                                
                                if($user_data3->last_name !== null){
                                    echo( "<br><span class='tribe_inst $tribe_events_inst3_stat'>" . $user_data3->last_name . ", " . $user_data3->first_name . "</span>" );
                                }
                            }
                        }
                        
                        else{ echo("None Assigned"); }
		}, 2);
		
		Jigsaw::add_column('tribe_events', 'Status', function($post_id){
                        
                        $tribe_events_status = get_post_meta($post_id, '_tribe_events_status', TRUE);
			if($tribe_events_status == "scheduled"){$status = "Scheduled";}
			else if($tribe_events_status == "cancelled"){$status = "Cancelled";}
			else if($tribe_events_status == "completed"){$status = "Completed";}
			echo( $status );
		}, 3);
		
		Jigsaw::add_column('tribe_events', 'Class Date', function($post_id){
			$class_date = tribe_get_start_date($post_id);
			echo( $class_date );
		}, 4);
		
		Jigsaw::add_column('tribe_events', 'Location', function($post_id){
			$venue = tribe_get_venue($post_id);
			$location = tribe_get_full_address($post_id, true);
			echo( $venue."<br>".$location );
		}, 5);
		
		Jigsaw::add_column('tribe_events', 'Date Added', function($post_id){
			$pfx_date = get_the_date( 'm/d/Y', $post_id );
			echo( $pfx_date );
		}, 10);
		
		Jigsaw::remove_column('tribe_events', 'comments');
		Jigsaw::remove_column('tribe_events', 'author');
		Jigsaw::remove_column('tribe_events', 'feature');
		Jigsaw::remove_column('tribe_events', 'image');
		Jigsaw::remove_column('tribe_events', 'thumb');
		Jigsaw::remove_column('tribe_events', 'thumbnail');
		Jigsaw::remove_column('tribe_events', 'date');
		Jigsaw::remove_column('tribe_events', 'start-date');
		Jigsaw::remove_column('tribe_events', 'end-date');
		Jigsaw::remove_column('tribe_events', 'tags');
	}
}



?>