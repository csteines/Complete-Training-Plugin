<?php

function SWSCTP_register_required_plugins(){
    /*
    * Array of plugin arrays. Required keys are name and slug.
    * If the source is NOT from the .org repo, then source is also required.
    */
    
    $plugins = array(
        array(
            'name'               => 'The Events Calendar', // The plugin name.
            'slug'               => 'the-events-calendar', // The plugin slug (typically the folder name).
            'source'             => SWSCTP_PLUGIN_DIR . '/plugin-source/the-events-calendar.4.1.1.1.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '4.1.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),  

        array(
            'name'               => 'WooCommerce', // The plugin name.
            'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
            'source'             => SWSCTP_PLUGIN_DIR . '/plugin-source/woocommerce.2.5.5.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '2.5.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        array(
            'name'               => 'Event Tickets Plus', // The plugin name.
            'slug'               => 'event-tickets-plus', // The plugin slug (typically the folder name).
            'source'             => SWSCTP_PLUGIN_DIR . '/plugin-source/event-tickets-plus.4.1.1.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '4.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        array(
            'name'               => 'Event Tickets', // The plugin name.
            'slug'               => 'event-tickets', // The plugin slug (typically the folder name).
            'source'             => SWSCTP_PLUGIN_DIR . '/plugin-source/event-tickets.4.1.1.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '4.1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        )
    );
    
    $config = array(
        'strings'      => array(
                'page_title'                      => __( 'Install Required Plugins', 'plugin-slug' ),
                'menu_title'                      => __( 'Install Plugins', 'plugin-slug' ),
                'installing'                      => __( 'Installing Plugin: %s', 'plugin-slug' ), // %s = plugin name.
                'oops'                            => __( 'Something went wrong with the plugin API.', 'plugin-slug' ),
                'notice_can_install_required'     => _n_noop(
                        'This plugin requires the following plugin: %1$s.',
                        'This plugin requires the following plugins: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_can_install_recommended'  => _n_noop(
                        'This plugin recommends the following plugin: %1$s.',
                        'This plugin recommends the following plugins: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_cannot_install'           => _n_noop(
                        'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update'            => _n_noop(
                        'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this plugin: %1$s.',
                        'The following plugins need to be updated to their latest version to ensure maximum compatibility with this plugin: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_ask_to_update_maybe'      => _n_noop(
                        'There is an update available for: %1$s.',
                        'There are updates available for the following plugins: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_cannot_update'            => _n_noop(
                        'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_can_activate_required'    => _n_noop(
                        'The following required plugin is currently inactive: %1$s.',
                        'The following required plugins are currently inactive: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop(
                        'The following recommended plugin is currently inactive: %1$s.',
                        'The following recommended plugins are currently inactive: %1$s.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'notice_cannot_activate'          => _n_noop(
                        'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                        'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                        'plugin-slug'
                ), // %1$s = plugin name(s).
                'install_link'                    => _n_noop(
                        'Begin installing plugin',
                        'Begin installing plugins',
                        'plugin-slug'
                ),
                'update_link' 					  => _n_noop(
                        'Begin updating plugin',
                        'Begin updating plugins',
                        'plugin-slug'
                ),
                'activate_link'                   => _n_noop(
                        'Begin activating plugin',
                        'Begin activating plugins',
                        'plugin-slug'
                ),
                'return'                          => __( 'Return to Required Plugins Installer', 'plugin-slug' ),
                'plugin_activated'                => __( 'Plugin activated successfully.', 'plugin-slug' ),
                'activated_successfully'          => __( 'The following plugin was activated successfully:', 'plugin-slug' ),
                'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'plugin-slug' ),  // %1$s = plugin name(s).
                'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this plugin. Please update the plugin.', 'plugin-slug' ),  // %1$s = plugin name(s).
                'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'plugin-slug' ), // %s = dashboard link.
                'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'tgmpa' ),

                'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        ),		
    );
    
    tgmpa( $plugins, $config );
        
}

?>