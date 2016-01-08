<?php

function add_roles_on_plugin_activation() {
      add_role( 'instructor', 'Instructor', array( 'read' => true, 'edit' => true, 'delete' => false, 'level_0' => true ) );
      remove_role('employee');
      remove_role('contributor');
      remove_role('subscriber');
      remove_role('author');

}
   
function sws_change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //print_r($roles);

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['editor']['name'] = 'Manager';
    $wp_roles->role_names['editor'] = 'Manager';  

    $role = get_role('editor');
    $role->add_cap('add_users');
    $role->add_cap('list_users');
    $role->add_cap('edit_users');
    $role->add_cap('delete_users');
    $role->add_cap('manage_options');      
}


function sws_remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}

?>