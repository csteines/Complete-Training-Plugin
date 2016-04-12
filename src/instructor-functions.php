<?php

/* 
 * Instructor Functions for Complete Training Plugin
 * 
 * version 0.0.1
 * 
 */

// handle custom page
// do flush if changing rule, then reload an admin page
// action added to ativation hook
function swsctp_handle_custompage_route()
{
    add_rewrite_rule('instructor-class-list(/page/([^/]+))?', 'index.php?class_list_var=1&page=$matches[2]', 'top');
    add_rewrite_rule('instructor-class-list/', 'index.php?class_list_var=1', 'top' );
    add_rewrite_rule('event/([^/]*)/inst-view/?', 'index.php?post_type=tribe_events&name=$matches[1]&inst_view=1', 'top' );
    
    flush_rewrite_rules();

}
 
add_filter('init', 'swsctp_declare_class_list_vars');
function swsctp_declare_class_list_vars()
{
    add_rewrite_tag('%class_list_var%', '([^&]+)');
    add_rewrite_tag('%inst_view%', '([^&]+)');
}
 
add_filter('template_include', 'swsctp_my_template', 1, 1);
function swsctp_my_template($template)
{
    global $wp_query;
 
    if (isset($wp_query->query_vars['class_list_var'])) {
        $new_template = locate_template( array( 'template-class-list.php' ) );
        if ( '' != $new_template ) {
        }
        else{ 
            $new_template = dirname( __FILE__ ) . '/templates/template-class-list.php'; 
        }
        return $new_template;
    }
    return $template;
}
