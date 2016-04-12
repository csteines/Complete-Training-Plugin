<?php
/*
 * Tribe Events Functions
 * Modifying the Tribe Events Custom Post Type 
 * 
 * version: 0.0.1
 */
//error_log("Tribe Functions Entered");

//add_action( 'admin_init', 'SWSCTP_tribe_functions' );

function SWSCTP_tribe_functions(){
    
    remove_post_type_support( 'tribe_events', 'excerpt' );
    remove_post_type_support( 'tribe_events', 'trackbacks' );
    remove_post_type_support( 'tribe_events', 'custom-fields' );
    remove_post_type_support( 'tribe_events', 'comments' );
    
    add_meta_box(   'sws-te-type-div-details', __('Class Details'),  'class_details_metabox', 'tribe_events', 'normal', 'low');
    add_meta_box(   'sws-te-type-div-signatures', __('Instructor Signatures'),  'class_sigs_metabox', 'tribe_events', 'normal', 'low');
    add_meta_box(   'sws-te-type-div-audit', __('Audit Trail'),  'class_audit_metabox', 'tribe_events', 'normal', 'low');
    add_meta_box(   'sws-te-type-div-status', __('Course Status'),  'class_status_metabox', 'tribe_events', 'side');
    
    function class_details_metabox($post) {
        $tribe_events_type = get_post_meta($post->ID, '_tribe_events_type', TRUE);
        if (!$tribe_events_type) $tribe_events_type = 'attachment';
        $inst_users_args = array(
            'role'      => 'instructor',
            'orderby'   => 'last_name'
        );
        
        $man_users_args = array(
            'role'      => 'editor',
            'orderby'   => 'last_name'
        );
        
        $blogusers_inst = get_users( $inst_users_args );
        $blogusers_man = get_users( $man_users_args );
        
        $wpe_args = array(
            'media_buttons' => false,
            'textarea_rows' => 10
        );
        
        //Get Saved Instructors
        $tribe_events_inst1 = get_post_meta($post->ID, '_tribe_events_inst1', TRUE);
        $tribe_events_inst2 = get_post_meta($post->ID, '_tribe_events_inst2', TRUE);
        $tribe_events_inst3 = get_post_meta($post->ID, '_tribe_events_inst3', TRUE);
        
        //Get Saved Instructor Statuses
        $tribe_events_inst1_stat = get_post_meta($post->ID, '_tribe_events_inst1_stat', TRUE);
        $tribe_events_inst2_stat = get_post_meta($post->ID, '_tribe_events_inst2_stat', TRUE);
        $tribe_events_inst3_stat = get_post_meta($post->ID, '_tribe_events_inst3_stat', TRUE);
        
        //If Status DNE || is blank, set status to "pending"
        if(!$tribe_events_inst1_stat || $tribe_events_inst1_stat == ""){ $tribe_events_inst1_stat = "pending"; }
        if(!$tribe_events_inst2_stat || $tribe_events_inst2_stat == ""){ $tribe_events_inst2_stat = "pending"; }
        if(!$tribe_events_inst3_stat || $tribe_events_inst3_stat == ""){ $tribe_events_inst3_stat = "pending"; }
        
        //If Instructor DNE || is blank, set status to blank ---> No instructor means no status
        if(!$tribe_events_inst1 || $tribe_events_inst1 == ""){ $tribe_events_inst1_stat = ""; }
        if(!$tribe_events_inst2 || $tribe_events_inst2 == ""){ $tribe_events_inst2_stat = ""; }
        if(!$tribe_events_inst3 || $tribe_events_inst3 == ""){ $tribe_events_inst3_stat = ""; }
                        
        //Get all other saved class details metabox items
        $tribe_events_inst_rate_unit = get_post_meta($post->ID, '_tribe_events_inst_rate_unit', TRUE);
        $tribe_events_inst_rate = get_post_meta($post->ID, '_tribe_events_inst_rate', TRUE);
        $tribe_events_inst_notes = get_post_meta($post->ID, '_tribe_events_inst_notes', TRUE);
        $tribe_events_equip_needed = get_post_meta($post->ID, '_tribe_events_equip_needed', TRUE);
        if (!$tribe_events_inst_rate_unit){ $tribe_events_inst_rate_unit = 'class'; }   
        ?>
        <!-- Class Details Metabox -->
        <div class="bootstrap-wrapper">
            <!--<form>-->
                <!-- Hidden Inputs (nonce, instructor statuses, original instructors) -->
                <input type="hidden" name="tribe_events_type_noncename" id="tribe_events_type_noncename" value="<?php echo wp_create_nonce( 'tribe_events_type'.$post->ID );?>" />
                <input type="hidden" name="tribe_events_inst1_stat" id="tribe_events_inst1_stat" value="<?php echo $tribe_events_inst1_stat; ?>" />
                <input type="hidden" name="tribe_events_inst2_stat" id="tribe_events_inst2_stat" value="<?php echo $tribe_events_inst2_stat; ?>" />
                <input type="hidden" name="tribe_events_inst3_stat" id="tribe_events_inst3_stat" value="<?php echo $tribe_events_inst3_stat; ?>" />
                <input type="hidden" name="tribe_events_inst1_orig" id="tribe_events_inst1_orig" value="<?php echo $tribe_events_inst1; ?>" />
                <input type="hidden" name="tribe_events_inst2_orig" id="tribe_events_inst2_orig" value="<?php echo $tribe_events_inst2; ?>" />
                <input type="hidden" name="tribe_events_inst3_orig" id="tribe_events_inst3_orig" value="<?php echo $tribe_events_inst3; ?>" />
                <div class="form-row">
                    <div id="tribe_events_inst1_cont" class="col-md-4 sws-pad-btm">
                        <div class="form-group">
                            <label for="tribe_events_inst1" class="inst_label col-md-12">Instructor 1</label>
                            <select id="tribe_events_inst1" name="tribe_events_inst1" class="sws_tribe_events_select col-md-12">
                                <option disabled value="" <?php if($tribe_events_inst1 == "" || !$tribe_events_inst1){echo "selected='selected'";}?>></option>
                                <?php
                                    if(!empty($blogusers_man)){
                                        echo '<optgroup label="Managers">';
                                        foreach ( $blogusers_man as $user ){
                                            if ($tribe_events_inst1 == $user->ID){
                                                echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                            else{
                                                echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                        }
                                        echo '</optgroup>';
                                    }
                                    echo '<optgroup label="Instructors">';
                                    foreach ( $blogusers_inst as $user ) {
                                        if ($tribe_events_inst1 == $user->ID){
                                            echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                        else{
                                            echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                    }
                                    echo '</optgroup>';
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="tribe_events_inst2_cont" class="col-md-4 sws-pad-btm">
                        <div class="form-group">
                            <label for="tribe_events_inst2" class="inst_label col-md-12">Instructor 2</label>
                            <select id="tribe_events_inst2" name="tribe_events_inst2" class="sws_tribe_events_select col-md-12">
                                <option disabled value="" <?php if($tribe_events_inst2 == "" || !$tribe_events_inst2){echo "selected='selected'";}?>></option>
                                <?php
                                    if(!empty($blogusers_man)){
                                        echo '<optgroup label="Managers">';
                                        foreach ( $blogusers_man as $user ){
                                            if ($tribe_events_inst2 == $user->ID){
                                                echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                            else{
                                                echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                        }
                                        echo '</optgroup>';
                                    }
                                    echo '<optgroup label="Instructors">';
                                    foreach ( $blogusers_inst as $user ) {
                                        if ($tribe_events_inst2 == $user->ID){
                                            echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                        else{
                                            echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                    }
                                    echo '</optgroup>';
                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="tribe_events_inst3_cont" class="col-md-4 sws-pad-btm">
                        <div class="form-group">
                            <label for="tribe_events_inst3" class="inst_label col-md-12">Instructor 3</label>
                            <select id="tribe_events_inst3" name="tribe_events_inst3" class="sws_tribe_events_select col-md-12">
                                <option disabled value="" <?php if($tribe_events_inst3 == "" || !$tribe_events_inst3){echo "selected='selected'";}?>></option>
                                <?php
                                    if(!empty($blogusers_man)){
                                        echo '<optgroup label="Managers">';
                                        foreach ( $blogusers_man as $user ){
                                            if ($tribe_events_inst3 == $user->ID){
                                                echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                            else{
                                                echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                            }
                                        }
                                        echo '</optgroup>';
                                    }
                                    echo '<optgroup label="Instructors">';
                                    foreach ( $blogusers_inst as $user ) {
                                        if ($tribe_events_inst3 == $user->ID){
                                            echo '<option value="'.esc_html( $user->ID ).'" selected="selected">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                        else{
                                            echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                        }
                                    }
                                    echo '</optgroup>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row col-md-12">
                    <div class="sws-max-half">
                        <label for="tribe_events_inst_rate">Instructor Rate</label>
                        <div class="input-group"> 
                            <span class="input-group-addon">$</span>
                            <input type="number" <?php if($tribe_events_inst_rate){echo "value='$tribe_events_inst_rate'";}else{echo 'value="0.00"';}?> min="0" step="1.00" data-number-to-fixed="2" data-number-stepfactor="1" class="form-control currency" id="tribe_events_inst_rate" name="tribe_events_inst_rate" placeholder="0.00" />
                            <span class="input-group-addon">
                                <div class="btn-group rate-unit-btn-group" data-toggle="buttons">
                                    <label class="btn btn-xs btn-default <?php if($tribe_events_inst_rate_unit == "hour"){echo "active";}?>" for="hour">
                                        <input type="radio" class="btn btn-xs btn-primary" name="tribe_events_inst_rate_unit" id="hour" value="hour" <?php if($tribe_events_inst_rate_unit == "hour"){echo "checked='checked'";}?> />/ Hour
                                    </label>
                                    <label class="btn btn-xs btn-default <?php if($tribe_events_inst_rate_unit == "class"){echo "active";}?>" for="class">
                                        <input type="radio" class="btn btn-xs btn-primary" name="tribe_events_inst_rate_unit" id="class" value="class" <?php if($tribe_events_inst_rate_unit == "class"){echo "checked='checked'";}?> /> / Class
                                    </label>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div  class="form-row col-md-12">
                    <div class="sws-tribe-editor">
                        <label for="tribe_events_inst_notes">Instructor Notes</label>
                        <span class="help-block">List any information important for instructors (e.g. parking information)</span>
                        <?php wp_editor( stripslashes($tribe_events_inst_notes), 'tribe_events_inst_notes', $wpe_args ); ?>
                    </div>
                </div>
                <div  class="form-row col-md-12 last">
                    <div class="sws-tribe-editor">
                        <label for="tribe_events_equip_needed">Equipment Needed</label>
                        <span class="help-block">List any required equipment (include quantities)</span>
                        <?php wp_editor( stripslashes($tribe_events_equip_needed), 'tribe_events_equip_needed', $wpe_args ); ?>
                    </div>
                </div>
                <div class="">
                    <h6><i>The Complete Training Plugin</i></h6>
                </div>
            <!--</form>-->
        </div>
        <?php
    }
    function class_sigs_metabox($post) {
        $tribe_events_type = get_post_meta($post->ID, '_tribe_events_type', TRUE);
        if (!$tribe_events_type) $tribe_events_type = 'attachment';
        
        $tribe_events_inst1_sig = get_post_meta($post->ID, '_tribe_events_inst1_sig', TRUE);
        $tribe_events_inst2_sig = get_post_meta($post->ID, '_tribe_events_inst2_sig', TRUE);
        $tribe_events_inst3_sig = get_post_meta($post->ID, '_tribe_events_inst3_sig', TRUE);
        $tribe_events_inst1_sig_date = get_post_meta($post->ID, '_tribe_events_inst1_sig_date', TRUE);
        $tribe_events_inst2_sig_date = get_post_meta($post->ID, '_tribe_events_inst2_sig_date', TRUE);
        $tribe_events_inst3_sig_date = get_post_meta($post->ID, '_tribe_events_inst3_sig_date', TRUE);
        $tribe_events_inst1_sig_ip = get_post_meta($post->ID, '_tribe_events_inst1_sig_ip', TRUE);
        $tribe_events_inst2_sig_ip = get_post_meta($post->ID, '_tribe_events_inst2_sig_ip', TRUE);
        $tribe_events_inst3_sig_ip = get_post_meta($post->ID, '_tribe_events_inst3_sig_ip', TRUE);
        $tribe_events_inst1_decline = get_post_meta($post->ID, '_tribe_events_inst1_decline', TRUE);
        $tribe_events_inst2_decline = get_post_meta($post->ID, '_tribe_events_inst2_decline', TRUE);
        $tribe_events_inst3_decline = get_post_meta($post->ID, '_tribe_events_inst3_decline', TRUE);
        $tribe_events_inst1_decline_rsn = get_post_meta($post->ID, '_tribe_events_inst1_decline_rsn', TRUE);
        $tribe_events_inst2_decline_rsn = get_post_meta($post->ID, '_tribe_events_inst2_decline_rsn', TRUE);
        $tribe_events_inst3_decline_rsn = get_post_meta($post->ID, '_tribe_events_inst3_decline_rsn', TRUE);
        
           
        ?>
        <div class="bootstrap-wrapper">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#inst1">Instructor 1</a></li>
                <li><a data-toggle="tab" href="#inst2">Instructor 2</a></li>
                <li><a data-toggle="tab" href="#inst3">Instructor 3</a></li>
            </ul>

            <div class="tab-content">
                <div id="inst1" class="tab-pane fade in active">
                    <?php if($tribe_events_inst1_decline){ ?>
                    <h6 class="red">Instructor 1 Declined</h6>
                    <h6>Decline Reason:</h6>
                    <div class="well well-sm">
                        <?php echo $tribe_events_inst1_decline_rsn; ?>
                    </div>
                    <?php } 
                    else { ?>
                    <h6>Instructor 1 Signature:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst1_sig){ echo $tribe_events_inst1_sig; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
                    <h6>Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst1_sig_date){ echo $tribe_events_inst1_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst1_sig_ip){ echo $tribe_events_inst1_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                </div>
                <div id="inst2" class="tab-pane fade">
                    <?php if($tribe_events_inst2_decline){ ?>
                    <h6 class="red">Instructor 2 Declined</h6>
                    <h6>Decline Reason:</h6>
                    <div class="well well-sm">
                        <?php echo $tribe_events_inst2_decline_rsn; ?>
                    </div>
                    <?php } 
                    else { ?>
                    <h6>Instructor 2 Signature:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst2_sig){ echo $tribe_events_inst2_sig; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
                    <h6>Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst2_sig_date){ echo $tribe_events_inst2_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst2_sig_ip){ echo $tribe_events_inst2_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                </div>
                <div id="inst3" class="tab-pane fade">
                    <?php if($tribe_events_inst3_decline){ ?>
                    <h6 class="red">Instructor 3 Declined</h6>
                    <h6>Decline Reason:</h6>
                    <div class="well well-sm">
                        <?php echo $tribe_events_inst3_decline_rsn; ?>
                    </div>
                    <?php } 
                    else { ?>
                    <h6>Instructor 3 Signature:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst3_sig){ echo $tribe_events_inst3_sig; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
                    <h6>Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst3_sig_date){ echo $tribe_events_inst3_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst3_sig_ip){ echo $tribe_events_inst3_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    function class_audit_metabox($post) {
        $tribe_events_type = get_post_meta($post->ID, '_tribe_events_type', TRUE);
        if (!$tribe_events_type) $tribe_events_type = 'attachment';
        
        
        $tribe_events_audit = get_post_meta($post->ID, '_tribe_events_audit', TRUE);
        $tribe_events_audit_timestamp = get_post_meta($post->ID, '_tribe_events_audit_timestamp', TRUE);
        ?>
        <div class="bootstrap-wrapper">
            <h6><?php if($tribe_events_audit_timestamp){ echo "Last Event Timestamp:  $tribe_events_audit_timestamp"; } ?></h6>
            <div class="well well-sm audit-well">
                <?php echo $tribe_events_audit; ?>
            </div>
        </div>
        <?php
    }
    
    function class_status_metabox($post) {
        $tribe_events_type = get_post_meta($post->ID, '_tribe_events_type', TRUE);
        if (!$tribe_events_type) $tribe_events_type = 'attachment';
        
        
        $tribe_events_status = get_post_meta($post->ID, '_tribe_events_status', TRUE);
        ?>
        <div class="bootstrap-wrapper">
            <select id="tribe_events_status" name="tribe_events_status" class="sws_tribe_events_select sws-full-width">
                <option value="scheduled" <?php if($tribe_events_status == "scheduled" || !$tribe_events_status){echo "selected='selected'";} ?>>Scheduled</option>
                <option value="cancelled" <?php if($tribe_events_status == "cancelled"){echo "selected='selected'";} ?>>Cancelled</option>
                <option value="completed" <?php if($tribe_events_status == "completed"){echo "selected='selected'";} ?>>Completed</option>
            </select>
        </div>
        <?php
    }
}


function swsctp_save_tribe_data($post_id, $data) {
    //error_log(print_r($data, TRUE));

    
    //error_log("save_tribe_events_data");
    $swsctp_options = get_option( 'swsctp_options' );
    
    // verify this came from the our screen and with proper authorization.
    if ( !wp_verify_nonce( $_POST['tribe_events_type_noncename'], 'tribe_events_type'.$post_id )) {return $post_id;}

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){return $post_id;}

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) ){return $post_id;}


    // OK, we're authenticated: we need to find and save the data   
    $post = get_post($post_id);
    if ($post->post_type == 'tribe_events') { 
        //error_log("tribe-events post save");
        
        //If audit trail is empty, class is new...  Add notice to audit trail for class being created.
        $tribe_events_audit = get_post_meta($post_id, '_tribe_events_audit', TRUE);
        if($tribe_events_audit == ""){
            $inst1 = get_userdata($_POST['tribe_events_inst1']);
            $inst2 = get_userdata($_POST['tribe_events_inst2']);
            $inst3 = get_userdata($_POST['tribe_events_inst3']);
            
            $timestamp = current_time('m/d/Y H:i:s', false);
            $dateTime = new DateTime(); 
            $dateTime->setTimeZone(new DateTimeZone(get_option('timezone_string'))); 
            $timestamp .= " ". $dateTime->format('T');
            
            $tribe_events_audit_addition  = "<strong>Class Created</strong>";
            if($inst1->ID != ""){$tribe_events_audit_addition .= "<br>Assigned to: $inst1->first_name $inst1->last_name";}
            if($inst2->ID != ""){$tribe_events_audit_addition .= "<br>Assigned to: $inst2->first_name $inst2->last_name";}
            if($inst3->ID != ""){$tribe_events_audit_addition .= "<br>Assigned to: $inst3->first_name $inst3->last_name";}
            $tribe_events_audit_addition .= "<br><i>Timestamp: $timestamp</i><br><br>";
            update_post_meta($post_id, '_tribe_events_audit_timestamp', $timestamp);
            
            $tribe_events_audit = $tribe_events_audit_addition;
            update_post_meta($post_id, '_tribe_events_audit', $tribe_events_audit);
        }
        
        //Update Instructors
        update_post_meta($post_id, '_tribe_events_inst1', esc_attr($_POST['tribe_events_inst1']) );
        update_post_meta($post_id, '_tribe_events_inst2', esc_attr($_POST['tribe_events_inst2']) );
        update_post_meta($post_id, '_tribe_events_inst3', esc_attr($_POST['tribe_events_inst3']) );
       
        //Update Event Status
        update_post_meta($post_id, '_tribe_events_status', esc_attr($_POST['tribe_events_status']) );
        
        //Update Other Items
        update_post_meta($post_id, '_tribe_events_inst_rate', esc_attr($_POST['tribe_events_inst_rate']) );
        update_post_meta($post_id, '_tribe_events_inst_rate_unit', esc_attr($_POST['tribe_events_inst_rate_unit']) );
        update_post_meta($post_id, '_tribe_events_inst_notes', $_POST['tribe_events_inst_notes'] );
        update_post_meta($post_id, '_tribe_events_equip_needed', $_POST['tribe_events_equip_needed'] );
        
        /**Instructor Status Updates**/
        //If (Status DNE || is blank) && Instructor is defined, updated instructor status to "pending"
        if((!$_POST['tribe_events_inst1_stat'] || $_POST['tribe_events_inst1_stat'] == "") && esc_attr($_POST['tribe_events_inst1']) != "" ){update_post_meta($post_id, '_tribe_events_inst1_stat', "pending");}
        if((!$_POST['tribe_events_inst2_stat'] || $_POST['tribe_events_inst2_stat'] == "") && esc_attr($_POST['tribe_events_inst2']) != "" ){update_post_meta($post_id, '_tribe_events_inst2_stat', "pending");}
        if((!$_POST['tribe_events_inst3_stat'] || $_POST['tribe_events_inst3_stat'] == "") && esc_attr($_POST['tribe_events_inst3']) != "" ){update_post_meta($post_id, '_tribe_events_inst3_stat', "pending");}
        
        //If Original Instructor !== Instructor input, update instructor status to pending and clear instructor signature fields
        //Send notification to new instructor that they have new assignment
        if($swsctp_options['require_sig'] == 'true'){
            $message1 = "New class assignment.  Please review the class details and sign &amp; accept or decline the assignment.";
        } else {
            $message1 = "New class assignment.  Please see below for details.";
        }
        
        $subject1 = "New Class Assignment - Class #$post_id";
        $template1 = 'new-inst';
        
        $message2 = "This class has been cancelled, or you have been removed as an instructor.  You are no longer assigned to teach this class.";
        $subject2 = "Class #$post_id Cancelled/Instructor(s) Changed";
        $template2 = 'canc-inst';
        
        $orig1 = esc_attr($_POST['tribe_events_inst1_orig']);
        $orig2 = esc_attr($_POST['tribe_events_inst2_orig']);
        $orig3 = esc_attr($_POST['tribe_events_inst3_orig']);
        $new1  = esc_attr($_POST['tribe_events_inst1']);
        $new2  = esc_attr($_POST['tribe_events_inst2']);
        $new3  = esc_attr($_POST['tribe_events_inst3']);
        
        $new1_sig = $new2_sig = $new3_sig = false;
        
        //Check if Instructor 1 field == Old instructor 1 field
        if($orig1 != $new1){
//            update_post_meta($post_id, '_tribe_events_inst1_stat', "pending");
//            update_post_meta($post_id, '_tribe_events_inst1_sig', "");
//            update_post_meta($post_id, '_tribe_events_inst1_sig_date', "");
//            update_post_meta($post_id, '_tribe_events_inst1_sig_ip', "");
//            update_post_meta($post_id, '_tribe_events_inst1_decline', "");
//            update_post_meta($post_id, '_tribe_events_inst1_decline_rsn', "");
            
            //Check if new instructor was swapped from a different old spot
            if($new1 != $orig2 && $new1 != $orig3){
                if($swsctp_options['init_notice'] == 'true'){
                    swsctp_notification_email($template1, $message1, $subject1, 'red', $new1, $post_id, true, false, true);
                    update_post_meta($post_id, '_tribe_events_inst1_notify', date('Y-m-d'));
                    if($orig1 != ""){
                        swsctp_notification_email($template2, $message2, $subject2, 'red', $orig1, $post_id, true);
                    }
                }
                
                //Set array for new signature fields
                //If New instructor is blank, set status to blank
                //Else, set to pending
                if($new1 == ""){ $new1_sig['stat'] = ""; }
                else { 
                    if($swsctp_options['require_sig'] == 'true'){ $new1_sig['stat'] = "pending"; }
                    else { $new1_sig['stat'] = "assigned"; }
                }
                $new1_sig['sig'] = "";
                $new1_sig['sig_date'] = "";
                $new1_sig['sig_ip'] = "";
                $new1_sig['decline'] = "";
                $new1_sig['decline_rsn'] = "";
                $new1_sig['final'] = "";
            }
            //Else, if new instructor 1 was original 2
            else if($new1 == $orig2){
                $new1_sig = swsctp_get_orig_sig("2", $post_id);
            }
            //Else, if new instructor 1 was original 3
            else if($new1 == $orig3){
                $new1_sig = swsctp_get_orig_sig("3", $post_id);
            }
        }
        if($orig2 != $new2){
            
            //Check if new instructor was swapped from a different old spot
            if($new2 != $orig1 && $new2 != $orig3){
                if($swsctp_options['init_notice'] == 'true'){
                    swsctp_notification_email($template1, $message1, $subject1, 'red', $new2, $post_id, true, false, true);
                    update_post_meta($post_id, '_tribe_events_inst2_notify', date('Y-m-d'));
                    if($orig2 != ""){
                        swsctp_notification_email($template2, $message2, $subject2, 'red', $orig2, $post_id, true);
                    }
                }
                
                //Set array for new signature fields
                //If New instructor is blank, set status to blank
                //Else, set to pending
                if($new2 == ""){ $new2_sig['stat'] = ""; }
                else { 
                    if($swsctp_options['require_sig'] == 'true'){ $new2_sig['stat'] = "pending"; }
                    else { $new2_sig['stat'] = "assigned"; }
                }
                $new2_sig['sig'] = "";
                $new2_sig['sig_date'] = "";
                $new2_sig['sig_ip'] = "";
                $new2_sig['decline'] = "";
                $new2_sig['decline_rsn'] = "";
                $new2_sig['final'] = "";
            }
            //Else, if new instructor 2 was original 1
            else if($new1 == $orig2){
                $new2_sig = swsctp_get_orig_sig("1", $post_id);
            }
            //Else, if new instructor 2 was original 3
            else if($new1 == $orig3){
                $new2_sig = swsctp_get_orig_sig("3", $post_id);
            }
        }
        if($orig3 != $new3){
            
            //Check if new instructor was swapped from a different old spot
            if($new3 != $orig2 && $new3 != $orig1){
                if($swsctp_options['init_notice'] == 'true'){    
                    swsctp_notification_email($template1, $message1, $subject1, 'red', $new3, $post_id, true, false, true);
                    update_post_meta($post_id, '_tribe_events_inst3_notify', date('Y-m-d'));
                    if($orig3 != ""){
                        swsctp_notification_email($template2, $message2, $subject2, 'red', $orig3, $post_id, true);
                    }
                }
                
                //Set array for new signature fields
                //If New instructor is blank, set status to blank
                //Else, set to pending
                if($new3 == ""){ $new3_sig['stat'] = ""; }
                else { 
                    if($swsctp_options['require_sig'] == 'true'){ $new3_sig['stat'] = "pending"; }
                    else { $new3_sig['stat'] = "assigned"; }
                }
                $new3_sig['sig'] = "";
                $new3_sig['sig_date'] = "";
                $new3_sig['sig_ip'] = "";
                $new3_sig['decline'] = "";
                $new3_sig['decline_rsn'] = "";
                $new3_sig['final'] = "";
            }
            //Else, if new instructor 3 was original 2
            else if($new3 == $orig2){
                $new3_sig = swsctp_get_orig_sig("2", $post_id);
            }
            //Else, if new instructor 3 was original 1
            else if($new3 == $orig1){
                $new3_sig = swsctp_get_orig_sig("1", $post_id);
            }
        }
        
        //Take signature fields from above and update accordingly
        //Allows for swaps between instructor spots, without cancelling assignment 
        //and resending initial notification
        if($new1_sig){ swsctp_update_sig_fields($new1_sig, '1', $post_id); }
        if($new2_sig){ swsctp_update_sig_fields($new2_sig, '2', $post_id); }
        if($new3_sig){ swsctp_update_sig_fields($new3_sig, '3', $post_id); }
       

        return(esc_attr($_POST['tribe_events_inst1']));
    }
    return $post_id;
}

/**
 * 
 * @param string $inst_num - Instructor number to get meta for
 * @param string $post_id - Post ID
 * @return array
 */
function swsctp_get_orig_sig($inst_num, $post_id){
    
    $sig_fields['stat']         = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_stat', TRUE);
    $sig_fields['sig']          = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig', TRUE);
    $sig_fields['sig_date']     = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig_date', TRUE);
    $sig_fields['sig_ip']       = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig_ip', TRUE);
    $sig_fields['decline']      = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_decline', TRUE);
    $sig_fields['decline_rsn']  = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_decline_rsn', TRUE);
    $sig_fields['notify']       = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_notify', TRUE);
    $sig_fields['final']        = get_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_final', TRUE);

    return $sig_fields;
}

/**
 * Update signature fields for post meta
 * 
 * @param array $sig_fields - Array containing signature fields content
 * @param string $inst_num - Instructor number to be updated
 * @param string $post_id - Post ID
 * @return string
 */
function swsctp_update_sig_fields($sig_fields, $inst_num, $post_id){
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_stat', $sig_fields['stat']);
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig', $sig_fields['sig']);
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig_date', $sig_fields['sig_date']);
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_sig_ip', $sig_fields['sig_ip']);
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_decline', $sig_fields['decline']);
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_decline_rsn', $sig_fields['decline_rsn']);
    if(isset($sig_fields['notify'])){
        update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_notify', $sig_fields['notify']);
    }
    update_post_meta($post_id, '_tribe_events_inst'.$inst_num.'_final', $sig_fields['final']);
    
    return $post_id;
}
    

function remove_page_author_field() {
	remove_meta_box( 'authordiv' , 'tribe_events' , 'normal' ); 
}

//Copies CTP Modified The Events Calendar Email Template to Theme Override Directory
//Checks file for Version Number to ensure file is up-to-date
function include_tribe_reg_email(){
    $filename = SWSCTP_THEME_DIR . '/tribe-events/tickets/email.php';
    if(file_exists($filename)){
        $old_contents = file_get_contents($filename);
        
        if(!strpos($old_contents, SWSCTP_TRIBE_FILE_VERS)){
            $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/reg-email.php');
            $put_file = file_put_contents($filename, $new_contents);
            
            return $put_file;
        }
        
        else{
            return "Up-To-Date";
        }
    }
    
    else{
        if(!file_exists(SWSCTP_THEME_DIR.'/tribe-events/')) mkdir(SWSCTP_THEME_DIR. '/tribe-events/', 0755);
        if(!file_exists(SWSCTP_THEME_DIR.'/tribe-events/tickets/')) mkdir(SWSCTP_THEME_DIR . '/tribe-events/tickets/', 0755);
        
        touch($filename);
        $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/emails/reg-email.php');
        $put_file = file_put_contents($filename, $new_contents);
            
        return $put_file;
    }
}

//Copies CTP Modified The Events Calendar Single Event Template to Theme Override Directory
//Checks file for Version Number to ensure file is up-to-date
function include_tribe_single_event(){
    $filename = SWSCTP_THEME_DIR . '/tribe-events/single-event.php';
    if(file_exists($filename)){
        $old_contents = file_get_contents($filename);
        
        if(!strpos($old_contents, SWSCTP_TRIBE_FILE_VERS)){
            $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/templates/single-event.php');
            $put_file = file_put_contents($filename, $new_contents);
            
            return $put_file;
        }
        
        else{
            return "Up-To-Date";
        }
    }
    
    else{
        if(!file_exists(SWSCTP_THEME_DIR.'/tribe-events/')) mkdir(SWSCTP_THEME_DIR. '/tribe-events/', 0755);
        
        touch($filename);
        $new_contents = file_get_contents(SWSCTP_PLUGIN_DIR . '/src/templates/single-event.php');
        $put_file = file_put_contents($filename, $new_contents);
            
        return $put_file;
    }
}

//Add action to wootickets after save
//Adds functionality to force class registrations to be sold individually
function swsctp_wootickets_after_save_ticket($ticket_id, $event_id){
    update_post_meta( $ticket_id, '_sold_individually', 'yes' );
}
add_action('wootickets_after_save_ticket', 'swsctp_wootickets_after_save_ticket');


/**
 * Add scripts and styles for modals
 * 
 */
function swsctp_modal_scripts(){
    wp_register_script ( 'swsmodaljs' , plugins_url('/complete-training-plugin/js/modal-bootstrap.min.js') , array( 'jquery' ), NULL , false );
    wp_register_script ( 'swsacceptancejs' , plugins_url( '/complete-training-plugin/js/sws-acceptance-form.js'), array( 'jquery' ), NULL , false );
    wp_register_style ( 'modalcss' , plugins_url('/complete-training-plugin/css/modal-bootstrap.css'), '' , '', 'all' );

    wp_enqueue_script( 'swsmodaljs' );
    wp_enqueue_script( 'swsacceptancejs' );
    wp_enqueue_style( 'modalcss' );
}

/**
 * Adds Modals to Instructor View for Course Assignment Accept Form & Decline Form
 * Adds AcceptanceForm modal and DeclineForm modal
 * 
 * @param $event_id 
 */
function swsctp_add_modals_fn($event_id){
	$inst_view = get_query_var('inst_view');
	
	if($inst_view){     
            $curuser = wp_get_current_user();
        
?>
		<!-- Modal -->
        <div id="AcceptanceForm" class="modal fade" tabindex="-1">
	        <div class="modal-dialog">
		        <div class="modal-content">
			        <div class="modal-header" style="height:40px;">
			        	<h4 class="modal-title">Accept and Sign</h4>
			        </div><!-- /.modal-header -->
			        <div class="modal-body">
			        	<div class="contract" style="height:100%; overflow-y:scroll;">
                                            <!-- Cont Shortcode -->
                                            <?php do_shortcode('[contractor_agreement]');  ?>
		        		</div><!-- /.contract -->
			        </div><!-- /.modal-body -->
		        	<div class="modal-footer" style="height:206px;">
		        		<form id="edit_post_sign" name="edit_post_sign" method="post" action="" enctype="multipart/form-data">
			        		<div id="ack"><input type="checkbox" name="sws_ack" id="sws_chk" value="acknowledged" required><label for='sws_chk'><?php echo _e('I acknowledge I have read and understand the above contract.', 'swsctp'); ?></label></div>
			        		<div id="sig"><?php echo _e('Typing your name below serves as your electronic signature, accepting the class assignment and agreeing to the above contract.', 'swsctp'); ?><br>
					        	<input type="text" id="signature" name="signature" width="100%" placeholder="Enter Your Name" required>
				        	</div><!-- /.sig -->
					        <input class="tribe-events-button tribe-no-param btn btn-primary" id="submit" name="submit" type="submit" value="Sign">
					        <input class="tribe-events-button tribe-no-param btn btn-default" id="cancel" name="cancel" type="submit" data-dismiss="modal" value="Cancel">
					        
				        	<input type="hidden" name="postid" value="<?php echo get_the_ID(); ?>" /><!-- DONT REMOVE OR CHANGE -->
                                                <input type='hidden' name='swsctp-source' value='instructor-event' /><!-- DONT REMOVE OR CHANGE -->
                                                <input type='hidden' name='instructor-id' value='<?php echo $curuser->ID; ?>' /><!-- DONT REMOVE OR CHANGE -->
                                                <input type="hidden" name="action" value="edit_post_sign" /><!-- DONT REMOVE OR CHANGE -->
						</form><!-- /.edit_post_sign -->
			        </div><!-- /.modal-footer -->
		        </div><!-- /.modal-content -->
	        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
                        
		<!-- Modal 2 -->
        <div id="DeclineForm" class="modal fade" tabindex="-1">
	        <div class="modal-dialog">
		        <div class="modal-content">
		        	<div class="modal-header" style="height:25px;">
		        		<h4 class="modal-title">Decline Assignment</h4>
		        	</div><!-- /.modal-header -->
		        	<form id="edit_post_decline" name="edit_post_decline" method="post" action="" enctype="multipart/form-data">
			        	<div class="modal-body">
			        		<div class="decline-statement"><?php echo _e('Are you sure you wish to decline the course assignment?', 'swsctp'); ?></div>
			        		<textarea id="decline_reason" name="decline_reason" rows="4" placeholder="<?php echo _e('Please provide your reason for declining the class', 'swsctp'); ?>" style="width:95%; margin:auto; margin-bottom:10px;" required></textarea>
		        		</div><!-- /.modal-body -->
			        	<div class="modal-footer">
			        		<input class="tribe-events-button tribe-no-param btn btn-primary" id="submit" name="submit" type="submit" value="Decline">
					        <input class="tribe-events-button tribe-no-param btn btn-default" id="cancel" name="cancel" type="submit" data-dismiss="modal" value="Cancel">
					        
				        	<input type="hidden" name="postid" value="<?php echo get_the_ID(); ?>" /><!-- DONT REMOVE OR CHANGE -->
                                                <input type='hidden' name='swsctp-source' value='instructor-event' /><!-- DONT REMOVE OR CHANGE -->
                                                <input type='hidden' name='instructor-id' value='<?php echo $curuser->ID; ?>' /><!-- DONT REMOVE OR CHANGE -->
                                                <input type="hidden" name="action" value="edit_post_decline" /><!-- DONT REMOVE OR CHANGE -->
			        	</div><!-- /.modal-footer -->
		        	</form>
		        </div><!-- /.modal-content -->
	        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->	
		
	<?php } //endif $inst_view
}
add_action('swsctp_add_instructor_modals', 'swsctp_add_modals_fn');


/**
 * Sign & Decline form processing
 */
function swsctp_inst_sign_decline(){
    //If POST submitted from Single Event Instructor View form
    if(isset($_POST['swsctp-source']) && $_POST['swsctp-source'] == 'instructor-event'){
        $curuser = wp_get_current_user();
        $post_id = $_POST['postid'];
        
        //Get Saved Instructors
        $tribe_events_inst1 = get_post_meta($post_id, '_tribe_events_inst1', TRUE);
        $tribe_events_inst2 = get_post_meta($post_id, '_tribe_events_inst2', TRUE);
        $tribe_events_inst3 = get_post_meta($post_id, '_tribe_events_inst3', TRUE);
        
        //Determine which instructor submitted the form
        $user_id = $_POST['instructor-id'];
        if($user_id == $tribe_events_inst1){ $inst = 1; }
        else if($user_id == $tribe_events_inst2){ $inst = 2; }
        else if($user_id == $tribe_events_inst3){ $inst = 3; }
        
        //If form signature
        if($_POST['action'] == 'edit_post_sign' && $_POST['sws_ack'] == true && $_POST['signature'] !== ""){
            
            $timestamp = current_time('m/d/Y H:i:s', false);
            $dateTime = new DateTime(); 
            $dateTime->setTimeZone(new DateTimeZone(get_option('timezone_string'))); 
            $timestamp .= " ". $dateTime->format('T');
           
            //Update post meta
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_stat', "accepted");
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig', $_POST['signature']);
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig_date', $timestamp);
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig_ip', $_SERVER['REMOTE_ADDR']);
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_decline', "");
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_decline_rsn', "");
            
            //Execute Notification Email Function
            $message = "Thank you for accepting the class and signing the agreement.  A reminder for the class will be sent about 2 days prior.";
            $subject = "Class #$post_id - Accepted";
            swsctp_notification_email('new-inst', $message, $subject, 'green', $user_id, $post_id, false);
            
            //Get Manager users for manager notifications
            $user_query = new WP_User_Query( array( 'role' => 'editor' ) );
            // User Loop
            if ( !empty( $user_query->results ) ) {
                foreach ( $user_query->results as $user ) {
                    $manager_message = "accepted";
                    swsctp_notification_email('manager', $manager_message, $subject, 'green', $user->ID, $post_id, false, $user_id, $inst);
                }
            }
            
            //Audit Trail Addition
            swsctp_sign_decline_audit($user_id, $post_id, 'accepted', $_SERVER['REMOTE_ADDR']);
            
        }
        //If form decline
        else if($_POST['action'] == 'edit_post_decline'){
            
            $timestamp = current_time('m/d/Y H:i:s', false);
            $dateTime = new DateTime(); 
            $dateTime->setTimeZone(new DateTimeZone(get_option('timezone_string'))); 
            $timestamp .= " ". $dateTime->format('T');
            
            //Update post meta
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_stat', "declined");
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig', "");
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig_date', $timestamp);
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_sig_ip', $_SERVER['REMOTE_ADDR']);
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_decline', "true");
            update_post_meta($post_id, '_tribe_events_inst'.$inst.'_decline_rsn', $_POST['decline_reason']);
            
            //Execute Notification Email Function
            $message = "You have opted to decline the class assignment.  You will receive another email once a manager has removed you from the class listing.";
            $subject = "Class #$post_id - Declined";
            swsctp_notification_email('canc-inst', $message, $subject, 'orange', $user_id, $post_id, false);
            
            //Get Manager users for manager notifications
            $user_query = new WP_User_Query( array( 'role' => 'editor' ) );
            // User Loop
            if ( !empty( $user_query->results ) ) {
                foreach ( $user_query->results as $user ) {
                    $manager_message = "declined";
                    swsctp_notification_email('manager', $manager_message, $subject, 'orange', $user->ID, $post_id, false, $user_id, $inst);
                }
            }
            
            //Audit Trail Addition
            swsctp_sign_decline_audit($user_id, $post_id, 'declined', $_SERVER['REMOTE_ADDR'], $_POST['decline_reason']);
        }
    }
}


/**
 * Accept & Decline Audit Trail Addition
 * 
 * @param string $user_id - User ID submitting form
 * @param string $event_id - Event ID
 * @param string $type - Type of entry
 * @param string $ip - IP address form was submitted from
 * @param string/boolean $decline_rsn - Reason for decline - default: false
 * @return string
 */
function swsctp_sign_decline_audit($user_id, $event_id, $type, $ip, $decline_rsn = false){
    $tribe_events_audit = get_post_meta($event_id, '_tribe_events_audit', TRUE);

    $user_data = get_userdata($user_id);
    
    $timestamp = current_time('m/d/Y H:i:s', false);
    $dateTime = new DateTime(); 
    $dateTime->setTimeZone(new DateTimeZone(get_option('timezone_string'))); 
    $timestamp .= " ". $dateTime->format('T');

    $tribe_events_audit_addition  = "<strong>Class $type by: $user_data->first_name $user_data->last_name</strong><br>";
    if($decline_rsn){ $tribe_events_audit_addition .= "Reason: $decline_rsn<br>"; }
    $tribe_events_audit_addition .= "IP Address: $ip<br>";
    $tribe_events_audit_addition .= "Timestamp: $timestamp<br><br>";
    $tribe_events_audit = $tribe_events_audit_addition . $tribe_events_audit;

    update_post_meta($event_id, '_tribe_events_audit', $tribe_events_audit);
    update_post_meta($event_id, '_tribe_events_audit_timestamp', $timestamp);
    
    return $timestamp;
}


/**
 * Tribe event reminders function
 * This function queries all tribe_events type posts and sends all reminders and final notifications as needed
 */
function swsctp_tribe_event_reminders(){
    //error_log(__FUNCTION__);
    //Define Now variables for current date
    $now_dt = date('Y-m-d H:i:s');
    $now = date('Y-m-d');
    //Define all remaining date variables to be used
    $swsctp_options = get_option( 'swsctp_options' );
    $frequency = $swsctp_options['sig_needed_reminder_time'];
    $reminder = $swsctp_options['course_reminder_time'];
    $freq_range = date('Y-m-d', strtotime("$now -$frequency days"));
    $start_range = date('Y-m-d', strtotime("$now +$reminder days"));
    
    //Define argurments for WP_query function
    $args = array(
	'post_type'  => 'tribe_events',
	'meta_key'   => '_EventStartDate',
	'orderby'    => 'meta_value_num',
	'order'      => 'ASC',
	'meta_query' => array(
            'relation' => 'AND',
            //Meta query entry for Event Start Date... Class must be in future
            array(
                'key'     => '_EventStartDate',
                'value'   => $now_dt,
                'compare' => '>',
            ),
            //Meta query entry for Class Status field... Must equal scheduled (i.e., not cancelled or completed)
            array(
                'key'     => '_tribe_events_status',
                'value'   => 'scheduled',
                'compare' => '='
            )
	),
    );

    //Execute WP_query to get all events that have not yet passed
    $the_query = new WP_Query( $args );
    
    // The Loop
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            
            $postid = $the_query->post->ID;
            $startDate = get_post_meta($postid, '_EventStartDate', TRUE);
            //error_log("Entered CJ Post #$postid");
            //error_log("Start Date: $startDate");
            //error_log("frequency: $frequency");
            //error_log("freq range: $freq_range");
            //error_log("reminder: $reminder");
            //error_log("start range: $start_range");
            
            //Set instructor counter
            $inst = 1;
            //While On instructor 1 through 3, perform function
            while ( $inst <= 3){
                //error_log("in instructor loop: $inst");
                $inst_stat = get_post_meta($postid, '_tribe_events_inst'.$inst.'_stat', TRUE);
                $inst_final = get_post_meta($postid, '_tribe_events_inst'.$inst.'_final', TRUE);
                //check if instructor needs to sign/decline
                if($inst_stat == "pending"){
                    //error_log("signature needed");
                    $inst_notify = get_post_meta($postid, '_tribe_events_inst'.$inst.'_notify', TRUE);
                    //check if reminder is eligible to be sent
                    if($inst_notify <= $freq_range /*&& $startDate > $start_range*/){
                        //error_log("action needed reminder sent");
                        $message = "This is a reminder your action is needed.  Please accept &amp; sign or decline the class assignment.";
                        $msg_color = "red";
                        $subject = "Action Needed - Class #$postid";
                        $inst_id = get_post_meta($postid, '_tribe_events_inst'.$inst, TRUE);
            
                        //Send reminder notification, update notification date meta, update audit trail
                        swsctp_notification_email('new-inst', $message, $subject, $msg_color, $inst_id, $postid, true);
                        update_post_meta($postid, '_tribe_events_inst'.$inst.'_notify', $now);
                    }//end if
                }//end if
                else{
                    //error_log("signature NOT needed");
                    //check if class is within final reminder timeframe AND final notification was not sent
                    if($startDate <= $start_range && ($inst_final == "" || !$inst_final) && $inst_stat != "declined"){
                        //error_log("final reminder sent");
                        $message = "This is a reminder you have an upcoming class schedule.  Complete details are below.";
                        $msg_color = "green";
                        $subject = "Final Reminder - Class #$postid";
                        $inst_id = get_post_meta($postid, '_tribe_events_inst'.$inst, TRUE);
            
                        //Send reminder notification, update notification date meta, update audit trail
                        swsctp_notification_email('new-inst', $message, $subject, $msg_color, $inst_id, $postid, true);
                        update_post_meta($postid, '_tribe_events_inst'.$inst.'_notify', $now);
                        update_post_meta($postid, '_tribe_events_inst'.$inst.'_final', "true");
                    }//end if
                }//end else
                //Iterate instructor variable for while
                $inst++;
            }//end while
        }//end while
    }//end if
    // Restore original Post Data
    wp_reset_postdata();
    //error_log("end CJ function");
}


/**
 * Filter Events Cateory Slug
 * 
 * Changes events category slug from "category" to "course"
 */
function swsctp_tribe_change_event_category_slug( $slug ) {
	
	$slug = "course";
	
	return $slug;
}
add_filter( 'tribe_events_category_slug', 'swsctp_tribe_change_event_category_slug' );




/**
 * TEMPORARY ADD LOGIN/LOGOUT LINK TO MENU
 * 
 * @param type $menu
 * @return type
 */
function wpsites_loginout_menu_link( $items, $args ) {
    $loginout = wp_loginout($_SERVER['REQUEST_URI'], false );
    $items .= "<li class='menu-item'>" . $loginout . "</li>";
    return $items;
}
add_filter( 'wp_nav_menu_items','wpsites_loginout_menu_link', 10, 2 );


/**
 * The following four filters change the events labels to "class"
 */
add_filter('tribe_event_label_singular', 'swsctp_change_single_events_label' );
function swsctp_change_single_events_label() {
    return 'Class';
}
  
add_filter('tribe_event_label_plural', 'swsctp_change_plural_events_label' );
function swsctp_change_plural_events_label() {
    return 'Classes';
}

add_filter('tribe_event_label_singular_lowercase', 'swsctp_change_singular_lowercase_event_label');
function swsctp_change_singular_lowercase_event_label() {
    return 'class';
}

add_filter('tribe_event_label_plural_lowercase', 'swsctp_change_plural_lowercase_event_label');
function swsctp_change_plural_lowercase_event_label() {
    return 'classes';
}
?>