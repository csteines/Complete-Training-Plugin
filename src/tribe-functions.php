<?php
/*
 * Tribe Events Functions
 * Modifying the Tribe Events Custom Post Type 
 */
error_log("Tribe Functions Entered");

//add_action( 'admin_init', 'SWSCTP_tribe_functions' );

function SWSCTP_tribe_functions(){
    
    remove_post_type_support( 'tribe_events', 'excerpt' );
    remove_post_type_support( 'tribe_events', 'trackbacks' );
    remove_post_type_support( 'tribe_events', 'custom-fields' );
    remove_post_type_support( 'tribe_events', 'comments' );
    
    add_meta_box(   'sws-te-type-div-details', __('Class Details'),  'class_details_metabox', 'tribe_events', 'normal', 'low');
    add_meta_box(   'sws-te-type-div-signatures', __('Instructor Signatures'),  'class_sigs_metabox', 'tribe_events', 'normal', 'low');
    add_meta_box(   'sws-te-type-div-audit', __('Audit Trail'),  'class_audit_metabox', 'tribe_events', 'normal', 'low');
    
    
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
        
        $tribe_events_inst1 = get_post_meta($post->ID, '_tribe_events_inst1', TRUE);
        $tribe_events_inst2 = get_post_meta($post->ID, '_tribe_events_inst2', TRUE);
        $tribe_events_inst3 = get_post_meta($post->ID, '_tribe_events_inst3', TRUE);
        $tribe_events_inst_rate_unit = get_post_meta($post->ID, '_tribe_events_inst_rate_unit', TRUE);
        $tribe_events_inst_rate = get_post_meta($post->ID, '_tribe_events_inst_rate', TRUE);
        $tribe_events_inst_notes = get_post_meta($post->ID, '_tribe_events_inst_notes', TRUE);
        $tribe_events_equip_needed = get_post_meta($post->ID, '_tribe_events_equip_needed', TRUE);
        if (!$tribe_events_inst_rate_unit) $tribe_events_inst_rate_unit = 'class';    
        ?>
        <div class="bootstrap-wrapper">
            <!--<form>-->
                <input type="hidden" name="tribe_events_type_noncename" id="tribe_events_type_noncename" value="<?php echo wp_create_nonce( 'tribe_events_type'.$post->ID );?>" />
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
                    <h5 class="red">Instructor 1 Declined</h5>
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
                    <h6>Signature Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst1_sig_date){ echo $tribe_events_inst1_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>Signature IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst1_sig_ip){ echo $tribe_events_inst1_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
                </div>
                <div id="inst2" class="tab-pane fade">
                    <?php if($tribe_events_inst2_decline){ ?>
                    <h5 class="red">Instructor 2 Declined</h5>
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
                    <h6>Signature Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst2_sig_date){ echo $tribe_events_inst2_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>Signature IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst2_sig_ip){ echo $tribe_events_inst2_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
                </div>
                <div id="inst3" class="tab-pane fade">
                    <?php if($tribe_events_inst3_decline){ ?>
                    <h5 class="red">Instructor 3 Declined</h5>
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
                    <h6>Signature Date:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst3_sig_date){ echo $tribe_events_inst3_sig_date; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <h6>Signature IP Address:</h6>
                    <div class="well well-sm">
                        <?php 
                        if($tribe_events_inst3_sig_ip){ echo $tribe_events_inst3_sig_ip; }
                        else{ echo " "; }
                        ?>
                    </div>
                    <?php } ?>
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
        $tribe_events_audit_timestamp = date('m/d/Y H:i:s');
        ?>
        <div class="bootstrap-wrapper">
            <h6><?php if($tribe_events_audit_timestamp){ echo "Last Event Timestamp:  $tribe_events_audit_timestamp"; } ?></h6>
            <div class="well well-sm audit-well">
                <?php echo $tribe_events_audit; ?>
            </div>
        </div>
        <?php
    }
    
    
    
 
    
}


function save_tribe_events_data($post_id) {  
    error_log("save_tribe_events_data");
    // verify this came from the our screen and with proper authorization.
    if ( !wp_verify_nonce( $_POST['tribe_events_type_noncename'], 'tribe_events_type'.$post_id )) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;


    // OK, we're authenticated: we need to find and save the data   
    $post = get_post($post_id);
    if ($post->post_type == 'tribe_events') { 
        error_log("tribe-events post save");
        update_post_meta($post_id, '_tribe_events_inst1', esc_attr($_POST['tribe_events_inst1']) );
        update_post_meta($post_id, '_tribe_events_inst2', esc_attr($_POST['tribe_events_inst2']) );
        update_post_meta($post_id, '_tribe_events_inst3', esc_attr($_POST['tribe_events_inst3']) );
        update_post_meta($post_id, '_tribe_events_inst_rate', esc_attr($_POST['tribe_events_inst_rate']) );
        update_post_meta($post_id, '_tribe_events_inst_rate_unit', esc_attr($_POST['tribe_events_inst_rate_unit']) );
        update_post_meta($post_id, '_tribe_events_inst_notes', $_POST['tribe_events_inst_notes'] );
        update_post_meta($post_id, '_tribe_events_equip_needed', $_POST['tribe_events_equip_needed'] );

        return(esc_attr($_POST['tribe_events_inst1']));
    }
    return $post_id;
}
    

function remove_page_author_field() {
	remove_meta_box( 'authordiv' , 'tribe_events' , 'normal' ); 
}


?>