<?php
   /*
    Plugin Name: LS WP Analytics
    Plugin URI: https://wordpress.org/plugins/ls-wp-analitics
    Description: This plugin display reports of traffic
    Version: 1.0.0
    Author: Lightning Soft  
    Author URI: https://lightning-soft.com/
    License: GPL2
   */

define('LS_WP_ANALYTICS_NAME', basename( __DIR__ ));

require __DIR__ . '/LS_WP_Analytics.php';

register_activation_hook( __FILE__, function() {
    LS_WP_Analytics::init();
});

/**
 * Added menu page
 */
  add_action( 'admin_menu', function() {
    add_menu_page(
        'LS WP Analytics',
        'LS WP Analytics',
        'manage_options',
        LS_WP_ANALYTICS_NAME .'/ls-wp-analytics-page.php',
        '',
        'dashicons-chart-bar',
        81
    );
});

/**
 * Added scripts
 */
add_action( 'wp_enqueue_scripts', function() {
    
    $current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
    $jsContent = file_get_contents(plugins_url('assets/js/main.min.js', __FILE__));
    wp_register_script( 'ls-wp-analytics-header', '');
    wp_enqueue_script( 'ls-wp-analytics-header');
    wp_add_inline_script('ls-wp-analytics-header', $jsContent);
    wp_localize_script( 'ls-wp-analytics-header', 'ls_wp_analytics', 
        array(
            'url' => admin_url('admin-ajax.php'),
            'is_archive' => is_archive(),
            'is_home' => is_home(),
            'slug' => is_archive() ? $current_page->slug : $current_page->post_name
        )
    );
} );

/**
 * Added ajax
 */
add_action( 'wp_ajax_nopriv_ls_wp_analytics', function () {
    $is_archive = sanitize_text_field($_POST['is_archive']);
    $is_home = sanitize_text_field($_POST['is_home']);
    $slug = sanitize_text_field($_POST['slug']);
    LS_WP_Analytics::insert($is_home, $is_archive, $slug);
	wp_die();
});