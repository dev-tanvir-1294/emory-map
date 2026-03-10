<?php
/**
 * Peachtree Location Finder Shortcode & Assets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Peachtree_Shortcode {

    public function __construct() {
        add_shortcode( 'peachtree_map', array( $this, 'render_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    public function enqueue_assets() {
        wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' );
        wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css' );
        wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true );

        wp_enqueue_style( 'peachtree-style', PEACHTREE_PLUGIN_URL . 'assets/css/style.css', array(), '1.1.0' );
        wp_enqueue_script( 'peachtree-script', PEACHTREE_PLUGIN_URL . 'assets/js/script.js', array( 'leaflet-js' ), '1.1.0', true );

        $locations_data = array();
        $query = new WP_Query( array(
            'post_type'      => 'peachtree_location',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ) );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $id = get_the_ID();
                $locations_data[] = array(
                    'name'    => get_the_title(),
                    'address' => get_post_meta( $id, '_map_address', true ),
                    'phone'   => get_post_meta( $id, '_map_phone', true ),
                    'rating'  => get_post_meta( $id, '_map_rating', true ),
                    'lat'     => (float) get_post_meta( $id, '_map_lat', true ),
                    'lng'     => (float) get_post_meta( $id, '_map_lng', true ),
                    'hours'   => get_post_meta( $id, '_map_hours', true ),
                );
            }
            wp_reset_postdata();
        }

        wp_localize_script( 'peachtree-script', 'peachtreeLocations', $locations_data );
    }

    public function render_shortcode() {
        ob_start();
        ?>
        <div class="peachtree-plugin-wrapper">
            <div class="boxed-wrapper">
                <div class="search-section">
                    <div class="search-input-container">
                        <input type="text" placeholder="Enter Address or Zip Code" />
                        <button class="btn btn-primary" id="use-my-location">
                            <i class="fa fa-crosshairs"></i> Use My Location
                        </button>
                    </div>
                </div>
                <main class="main-container">
                    <section class="sidebar">
                        <div class="location-list" id="location-list">
                            <!-- Dynamic rendering via script.js -->
                        </div>
                    </section>
                    <section class="map-container">
                        <div id="map" style="height: 100%; min-height: 400px;"></div>
                    </section>
                </main>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
