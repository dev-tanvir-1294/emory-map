<?php
/**
 * Plugin Name: Peachtree Location Finder
 * Description: A premium, interactive location finder with dynamic Custom Post Types.
 * Version: 1.1.0
 * Author: Antigravity
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define Plugin Constants
define( 'PEACHTREE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PEACHTREE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include Modular Class Files
require_once PEACHTREE_PLUGIN_DIR . 'includes/class-peachtree-cpt.php';
require_once PEACHTREE_PLUGIN_DIR . 'includes/class-peachtree-shortcode.php';

/**
 * Main Plugin Class
 */
class Peachtree_Location_Finder_Main {

    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_modules();
    }

    private function init_modules() {
        new Peachtree_CPT();
        new Peachtree_Shortcode();
    }
}

// Initialize the Plugin
function peachtree_location_finder_init() {
    Peachtree_Location_Finder_Main::get_instance();
}
add_action( 'plugins_loaded', 'peachtree_location_finder_init' );
