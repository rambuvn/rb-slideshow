<?php
/**
 * Plugin Name: RB rtCamp Wordpress Slideshow
 * Description: Submit for challenge 1
 * Author: rambu.dev
 * Author URI: mailto:vn.nqhung@gmail.com
 * Text Domain: rb-rtcamp
 * Version: 1.0.0.0
 */

if ( !defined('ABSPATH') ) {
    die('Get out please');
}

if ( !function_exists('rb_admin_menu') ) {
    /**
     * Create Menu Page 
     */
    function rb_admin_menu() {
        add_menu_page(
            __( 'Slide Show Settings', 'rb-rtcamp' ),
            'Slide Show',
            'manage_options',
            'rb-rtcamp-slideshow-settings',
            'rb_admin_setting_page',
            'dashicons-slides'
        );
    }
    add_action( 'admin_menu', 'rb_admin_menu');
}


if ( !function_exists('rb_register_plugin_settings') ) {
    // Register setting field for images 
    function rb_register_plugin_settings() {
        register_setting( 'rb-rtcamp-settings-group', '_rb_slideshow_images' );
    }
    add_action( 'admin_init', 'rb_register_plugin_settings' );
}

if ( !function_exists('rb_admin_setting_page') ) {
    // Display setting page 
    function rb_admin_setting_page() {
        include_once plugin_dir_path(__FILE__) . 'admin-page-settings.php';
    }
}

if ( !function_exists('rb_admin_enqueue_scripts') ) {
    // Include scripts and css only for admin page setting
    function rb_admin_enqueue_scripts() {
        $screen = get_current_screen();
        if ( strpos($screen->id, 'rb-rtcamp-slideshow-settings') === false) return;
        
        
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_media();
        wp_enqueue_script( 'rb-rtcamp-admin', plugin_dir_url(__FILE__) . '/assets/js/admin-main.js', ['jquery', 'jquery-ui-sortable'], '1.0.0.0', true );


        wp_enqueue_style( 'rb-rtcamp-admin', plugin_dir_url(__FILE__) . '/assets/css/admin-main.css' );
    }
    add_action('admin_enqueue_scripts', 'rb_admin_enqueue_scripts');
}


if ( !function_exists('rb_enqueue_scripts') ) {
    // Include scripts and css  in frontend 
    function rb_enqueue_scripts() {
        wp_enqueue_script( 'own-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', ['jquery'], '2.3.4', true );
        wp_enqueue_script( 'main', plugin_dir_url(__FILE__) . '/assets/js/main.js', ['jquery', 'own-carousel'], '1.0.0.0', true );

        wp_enqueue_style( 'own-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', [], '2.3.4' );
    }
    add_action('wp_enqueue_scripts', 'rb_enqueue_scripts');
}


if ( !function_exists('rb_rtcamp_slideshow_shortcode') ) {
    // Generate Slide show shortcode
    function rb_rtcamp_slideshow_shortcode() {
        ob_start();
        include_once plugin_dir_path(__file__) . '/shortcode-slideshow.php';
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    add_shortcode( 'myslideshow', 'rb_rtcamp_slideshow_shortcode' );
}