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
			$instructor1 = get_post_meta($post_id, 'instructor1', true);
			$instructor2 = get_post_meta($post_id, 'instructor2', true);
			$instructor3 = get_post_meta($post_id, 'instructor3', true);
                        
			$user_data1 = get_userdata($instructor1);
			$user_data2 = get_userdata($instructor2);
			$user_data3 = get_userdata($instructor3);
                        
                        if($user_data1->last_name !== null){
                            echo( $user_data1->last_name . ", " . $user_data1->first_name );
                            
                            if($user_data2->last_name !== null){
                                echo( "<br>".$user_data2->last_name . ", " . $user_data2->first_name );
                                
                                if($user_data3->last_name !== null){
                                    echo( "<br>".$user_data3->last_name . ", " . $user_data3->first_name );
                                }
                            }
                        }
                        
                        else{ echo("None Assigned"); }
		}, 2);
		
		Jigsaw::add_column('tribe_events', 'Status', function($post_id){
			$status = get_post_meta($post_id, 'course_status', true);
			if($status == "pending"){$status = "Pending";}
			else if($status == "accepted"){$status = "Accepted";}
			else if($status == "declined"){$status = "Declined";}
			else if($status == "cancelled"){$status = "Cancelled";}
			else if($status == "completed"){$status = "Completed";}
			echo( $status );
		}, 3);
		
		Jigsaw::add_column('course', 'Course Date/Time', function($post_id){
			$date = get_post_meta($post_id, 'date_/_time', true);
			$date = date('m/d/Y g:i A', (int) $date);
			echo( $date );
		}, 4);
		
		Jigsaw::add_column('course', 'Location', function($post_id){
			$location = get_post_meta($post_id, 'location', true);
			echo( $location['address'] );
		}, 5);
		
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