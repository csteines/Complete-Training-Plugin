<?php
/**
 * Single Event Template - Complete Training Plugin Override
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Includes modifications for Complete Training Plugin Instructor View
 *
 * @package TribeEventsCalendar
 * 
 * SWSCTP_VERSION = 0.0.1 
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

//Get Event ID & Check if Instructor View
$event_id = get_the_ID();
$inst_view = get_query_var('inst_view');
error_log("Instructor View: ".$inst_view);

if($inst_view){
    ?><!--Instructor Modals--><?php
    do_action('swsctp_add_instructor_modals', $event_id);
}
//If Instructor View and user is NOT logged in, provide login form
if($inst_view && !(is_user_logged_in())){      ?>
    <div id="tribe-events-content" class="tribe-events-single vevent hentry">
            <h3>You are accessing an employee only page.</h3>  
            <p>Please login, or <a href="<?php echo esc_url( tribe_get_events_link() ); ?>">click here</a> to view a complete calendar of courses</p> 
    <?php $login_form = wp_login_form( array('echo' => false));
            echo $login_form;?>
            <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" title="Forgot Your Password?">Forgot Your Password?</a>
    </div>

<?php }

else { 
    $curuser = wp_get_current_user();
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
    
    $site_url = site_url();

    //If public view
    if(!$inst_view){    ?>
        <div id="tribe-events-content " class="tribe-events-single vevent hentry">
            <p>
                <a href="<?php echo esc_url( tribe_get_events_link() ); ?>">&laquo; All Classes</a>
            </p>
    <?php }
    else { ?>
        <div id="tribe-events-content " class="instructor-view tribe-events-single vevent hentry">
            <p>
                <a href="<?php echo esc_url("$site_url/instructor-class-list/");?>">&laquo; My Assigned Classes</a>
            </p>
    <?php } ?>
    <!-- Notices -->
    <?php tribe_events_the_notices() ?>
    <?php if($inst_view){
            the_title( '<h2 class="tribe-events-single-event-title summary entry-title">', ' - Instructor Details</h2>' );
    }
    else{
            the_title( '<h2 class="tribe-events-single-event-title summary entry-title">', '</h2>' );
    }
    ?>

	<div class="tribe-events-schedule updated published tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<h3><span style="font-size:13px;">|</span></h3>
			<h3><span style="font-size:13px;">Student cost: <?php echo tribe_get_cost( null, true ) ?></span></h3>
		<?php endif; ?>
		
	</div>
        <!-- Event header -->
	<?php if(!$inst_view){ ?>
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<?php } ?>
	<!-- #tribe-events-header -->
        
	<?php if($inst_view){
	
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
        
        //Check if signature is required by current user
        if((    $curuser->ID == $tribe_events_inst1 && $tribe_events_inst1_stat == "pending" ) ||
           (    $curuser->ID == $tribe_events_inst2 && $tribe_events_inst2_stat == "pending" ) ||
           (    $curuser->ID == $tribe_events_inst3 && $tribe_events_inst3_stat == "pending" )){
            $inst_sign_needed = true;
        } 
        
        if($inst_view){ ?>
            <?php do_action( 'tribe_events_single_event_after_the_content' ); 
        } ?>

        <!-- Instructor Details -->
	<div class="tribe-events-single-section tribe-events-event-meta primary tribe-events-schedule updated published tribe-clearfix">
            <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-header">
                <h3 class="tribe-events-single-section-title"> Instructor Details </h3>
            </div>
            <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-left">
                <dl>
                    <dt> Class Status: </dt>
                    <dd>
                        <?php echo $status;?>
                    </dd>
                    <?php if($tribe_events_inst_rate){ ?>
                    <dt> Instructor Rate: </dt>
                    <dd class="tribe-events-event-inst-rate"> $<?php echo $tribe_events_inst_rate; echo $iru;?> </dd>
                    <?php } ?>
                </dl>
            </div>
            <div class="tribe-events-meta-group tribe-events-meta-group-details clearfix" id="tribe-events-inst-meta-right">
                <dl>
                    <dt> Instructors: </dt>
                    <dd>
                        <?php if(!$tribe_events_inst1){?>
                        No Instructors Assigned
                        <?php } else{ ?>
                        <div class="tribe_inst">
                            <?php echo $userdata1->first_name ." ". $userdata1->last_name;?> - <span class="<?php echo $tribe_events_inst1_stat;?>"><?php echo $inst1stat; ?></span>
                        </div>
                        <?php if($tribe_events_inst2){ ?>
                        <div class="tribe_inst">
                            <?php echo $userdata2->first_name ." ". $userdata2->last_name;?> - <span class="<?php echo $tribe_events_inst2_stat;?>"><?php echo $inst2stat; ?></span>
                        </div>
                        <?php } 
                        if($tribe_events_inst3){ ?>
                        <div class="tribe_inst">
                            <?php echo $userdata3->first_name ." ". $userdata3->last_name;?> - <span class="<?php echo $tribe_events_inst3_stat;?>"><?php echo $inst3stat; ?></span>
                        </div>
                        <?php }
                        if($inst_sign_needed){ ?>
                        <div id="inst-buttons">
                            <button class="tribe-events-button tribe-no-param" id="inst_view_button" data-toggle="modal" data-target="#AcceptanceForm" value="Accept and Sign">Accept and Sign</button>
                            <button class="tribe-events-button tribe-no-param" id="inst_decline_button" data-toggle="modal" data-target="#DeclineForm" value="Decline Assignment">Decline Assignment</button>
                        </div>
                        <?php }
                        } ?>
                    </dd>
                </dl>
            </div>
            <?php if($tribe_events_equip_needed || $tribe_events_inst_notes){ ?>
            <div class="tribe-events-meta-group tribe-events-meta-group-details" id="tribe-events-inst-meta-bottom">
                <dl>
                    <?php if($tribe_events_inst_notes){ ?>
                    <dt> Instructor Notes: </dt> 
                    <dd class="tribe-events-event-inst-notes"><?php echo $tribe_events_inst_notes; ?></dd>
                    <?php }
                    if($tribe_events_equip_needed){ ?>
                    <dt> Equipment Needed: </dt> 
                    <dd class="tribe-events-event-equip-needed"><?php echo $tribe_events_equip_needed; ?></dd>
                    <?php } ?>
                </dl>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
	
	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false );?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<?php if(!$inst_view){ the_content(); } ?>
			<!-- .tribe-events-single-event-description -->
			<?php if(!$inst_view){ ?>
                            <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
                        <?php } ?>
                        
			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                        <?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; 
        
        if(!$inst_view){ ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->
        <?php } ?>

</div><!-- #tribe-events-content -->

<?php if($inst_view){?>
<div id="inst_view_true" style="display:none">True</div>
<div id="inst_view_postid" style="display:none"><?php echo $event_id?></div>
<?php }
}

