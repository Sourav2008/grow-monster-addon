<?php
/**
 * Plugin Name: Grow Monster Addon – From GrowUp 2x
 * Description: A collection of 20+ custom Elementor widgets with toggle options.
 * Version: 1.0.0
 * Author: Sourav Chowdhury
 * Text Domain: grow-monster-addon
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// 1. Define path constants.
define( 'GMA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'GMA_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );

// 2. Include Admin Settings Page.
require_once GMA_PLUGIN_PATH . 'admin/settings-page.php';

// 3. Register widgets with Elementor based on toggles in admin settings.
add_action( 'elementor/widgets/register', 'gma_register_widgets' );
function gma_register_widgets( $widgets_manager ) {

    // Make sure Elementor is active.
    if ( ! did_action( 'elementor/loaded' ) ) {
        return;
    }

    // Retrieve an array of enabled widgets from our settings page.
    $enabled_widgets = get_option( 'gma_enabled_widgets', [] );
    $enable_all      = get_option( 'gma_enable_all_widgets', false ); // Enable all if checked.

    // Include widget files.
    require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-button.php';
    require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-scrolling-device.php';
    require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-creative-heading.php';
    require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-creative-accordion.php';
    // Uncomment and add additional widget files as needed:
    // require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-creative-accordion.php';
    // require_once GMA_PLUGIN_PATH . 'widgets/widget-grow-monster-creative-icon-image-box.php';
    // ... add other widget files here

    // Map widget keys to their class names.
    $widgets_map = [
        'grow_monster_button'           => '\GrowMonsterAddon\Widgets\Grow_Monster_Button',
        'grow_monster_scrolling_device' => '\GrowMonsterAddon\Widgets\Grow_Monster_Scrolling_Device',
        'grow_monster_creative_heading' => '\GrowMonsterAddon\Widgets\Grow_Monster_Creative_Heading_Widget',
        // Add additional mappings if you uncomment the corresponding files:
        'grow_monster_creative_accordion'         => '\GrowMonsterAddon\Widgets\Grow_Monster_Creative_Accordion',
        // 'grow_monster_creative_icon_image_box'    => '\GrowMonsterAddon\Widgets\Grow_Monster_Creative_Icon_Image_Box',
        // ... add other mappings here
    ];

    // Register widgets.
    if ( $enable_all ) {
        foreach ( $widgets_map as $class_name ) {
            if ( class_exists( $class_name ) ) {
                $widgets_manager->register( new $class_name );
            }
        }
    } else {
        foreach ( $enabled_widgets as $widget_key ) {
            if ( isset( $widgets_map[ $widget_key ] ) && class_exists( $widgets_map[ $widget_key ] ) ) {
                $widgets_manager->register( new $widgets_map[ $widget_key ] );
            }
        }
    }
}

/**
 * 4. Enqueue plugin-wide CSS/JS.
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'gma-styles',  GMA_PLUGIN_URL . 'assets/css/style.css', [], '1.0.0' );
    wp_enqueue_script( 'gma-scripts', GMA_PLUGIN_URL . 'assets/js/script.js', [ 'jquery' ], '1.0.0', true );
});

/**
 * 5. Enqueue Swiper CSS/JS.
 */
function gma_enqueue_swiper_assets() {
    wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', [], '9.0.0' );
    wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', [], '9.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'gma_enqueue_swiper_assets' );
