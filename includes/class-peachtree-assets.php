<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Handles all asset enqueuing for frontend and admin areas.
 */
class Peachtree_Assets
{

    public function __construct()
    {
  
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend'));

        
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));
    }

    /**
     * Enqueue scripts and styles for the frontend.
     */
    public function enqueue_frontend()
    {
        // global assets that can be loaded on any page
        wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

        // only load mapping/shortcode files when the shortcode is actually present in the current content
        if (is_singular() && has_shortcode(get_post()->post_content, 'peachtree_map')) {
            wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
            wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);

            wp_enqueue_style('peachtree-style', PEACHTREE_PLUGIN_URL . 'assets/css/style.css', array(), '1.1.0');
            wp_enqueue_script('peachtree-script', PEACHTREE_PLUGIN_URL . 'assets/js/script.js', array('leaflet-js'), '1.1.0', true);

            // collect location data and expose it to the frontend script
            $locations_data = array();
            $query = new WP_Query(array(
                'post_type'      => 'peachtree_location',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ));

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $id = get_the_ID();
                    $locations_data[] = array(
                        'name'    => get_the_title(),
                        'address' => get_post_meta($id, '_map_address', true),
                        'phone'   => get_post_meta($id, '_map_phone', true),
                        'rating'  => get_post_meta($id, '_map_rating', true),
                        'lat'     => (float) get_post_meta($id, '_map_lat', true),
                        'lng'     => (float) get_post_meta($id, '_map_lng', true),
                        'hours'   => get_post_meta($id, '_map_hours', true),
                    );
                }
                wp_reset_postdata();
            }

            wp_localize_script('peachtree-script', 'peachtreeLocations', $locations_data);
        }
    }

    /**
     * Enqueue assets for the admin area.
     *
     * Currently empty; add styles/scripts for plugin settings or post type metaboxes here.
     */
    public function enqueue_admin()
    {
        // example: wp_enqueue_style( 'peachtree-admin', PEACHTREE_PLUGIN_URL . 'assets/css/admin.css' );
    }
}