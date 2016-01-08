<?php
/*
 * Tribe Events Functions
 * Modifying the Tribe Events Custom Post Type 
 */
error_log("Tribe Functions Entered");

//add_action( 'admin_init', 'SWSCTP_tribe_functions' );

//function SWSCTP_tribe_functions(){
    //Addition of Meta Box to Tribe Events Post Type
    add_meta_box(   'sws-te-type-div', __('Class Details'),  'class_details_metabox', 'tribe_events', 'normal', 'low');
    
    function class_details_metabox($post) {
        $tribe_events_type = get_post_meta($post->ID, '_tribe_events_type', TRUE);
        if (!$tribe_events_type) $tribe_events_type = 'attachment';
        $users_args = array(
            'role'      => 'instructor',
            'orderby'   => 'display_name'
        );
        $blogusers = get_users( $users_args );
        ?>
        <div class="bootstrap-wrapper">
            <form>
                <div id="tribe_events_inst1" class="col-md-4">
                    <input type="hidden" name="tribe_events_type_noncename" id="tribe_events_type_noncename" value="<?php echo wp_create_nonce( 'tribe_events_type'.$post->ID );?>" />
                    <div class="form-group">
                        <label for="tribe_events_inst_1" class="col-md-12">Instructor 1<span class="red">*</span></label>
                        <select id="tribe_events_inst1" name="tribe_events_inst1" class="sws_tribe_events_select col-md-12">
                            <?php
                                foreach ( $blogusers as $user ) {
                                    echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="tribe_events_inst2" class="col-md-4">
                    <div class="form-group">
                        <label for="tribe_events_inst2" class="col-md-12">Instructor 2</label>
                        <select id="tribe_events_inst2" name="tribe_events_inst2" class="sws_tribe_events_select col-md-12">
                            <?php
                                foreach ( $blogusers as $user ) {
                                    echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="tribe_events_inst3" class="col-md-4">
                    <div class="form-group">
                        <label for="tribe_events_inst3" class="col-md-12">Instructor 3</label>
                        <select id="tribe_events_inst3" name="tribe_events_inst3" class="sws_tribe_events_select col-md-12">
                            <?php
                                foreach ( $blogusers as $user ) {
                                    echo '<option value="'.esc_html( $user->ID ).'">' . esc_html( $user->display_name ) . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }
//}




?>