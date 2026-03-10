<?php

/**
 * Peachtree Location Finder CPT & Meta Boxes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Peachtree_CPT {

    public function __construct() {
        add_action( 'init', array( $this, 'register_location_cpt' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_location_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_location_meta' ) );
    }

    public function register_location_cpt() {
        $labels = array(
            'name'               => 'Map Locations',
            'singular_name'      => 'Map Location',
            'menu_name'          => 'Map Locations',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Map Location',
            'edit_item'          => 'Edit Map Location',
            'new_item'           => 'New Map Location',
            'view_item'          => 'View Map Location',
            'search_items'       => 'Search Map Locations',
            'not_found'          => 'No Map locations found',
            'not_found_in_trash' => 'No Map locations found in trash',
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => false,
            'menu_icon'           => 'dashicons-location-alt',
            'supports'            => array( 'title' ),
            'capability_type'     => 'post',
            'publicly_queryable'  => true,
            'rewrite'             => array( 'slug' => 'map-location' ),
        );

        register_post_type( 'peachtree_location', $args );
    }

    public function add_location_meta_boxes() {
        add_meta_box(
            'peachtree_location_details',
            'Location Details',
            array( $this, 'render_location_meta_box' ),
            'peachtree_location',
            'normal',
            'high'
        );
    }

    public function render_location_meta_box( $post ) {
        $address = get_post_meta( $post->ID, '_map_address', true );
        $phone   = get_post_meta( $post->ID, '_map_phone', true );
        $rating  = get_post_meta( $post->ID, '_map_rating', true );
        $lat     = get_post_meta( $post->ID, '_map_lat', true );
        $lng     = get_post_meta( $post->ID, '_map_lng', true );
        $hours   = get_post_meta( $post->ID, '_map_hours', true );

        wp_nonce_field( 'peachtree_location_nonce_action', 'peachtree_location_nonce' );
        ?>
<style>
.peachtree-meta-row {
    margin-bottom: 20px;
}

.peachtree-meta-row label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.peachtree-meta-row input {
    width: 100%;
    padding: 8px;
}
</style>
<div class="peachtree-meta-row">
    <label for="map_address">Full Address</label>
    <input type="text" id="map_address" name="map_address" value="<?php echo esc_attr( $address ); ?>"
        placeholder="e.g. 3540 Cobb Pkwy NW, Acworth, GA 30101">
</div>
<div class="peachtree-meta-row">
    <label for="map_phone">Phone Number</label>
    <input type="text" id="map_phone" name="map_phone" value="<?php echo esc_attr( $phone ); ?>"
        placeholder="e.g. 770-974-3911">
</div>
<div class="peachtree-meta-row">
    <label for="map_rating">Google Rating (e.g. 4.8)</label>
    <input type="text" id="map_rating" name="map_rating" value="<?php echo esc_attr( $rating ); ?>">
</div>
<div style="display: flex; gap: 20px;">
    <div class="peachtree-meta-row" style="flex: 1;">
        <label for="map_lat">Latitude</label>
        <input type="text" id="map_lat" name="map_lat" value="<?php echo esc_attr( $lat ); ?>">
    </div>
    <div class="peachtree-meta-row" style="flex: 1;">
        <label for="map_lng">Longitude</label>
        <input type="text" id="map_lng" name="map_lng" value="<?php echo esc_attr( $lng ); ?>">
    </div>
</div>
<div class="peachtree-meta-row">
    <label for="map_hours">Operating Hours</label>
    <input type="text" id="map_hours" name="map_hours" value="<?php echo esc_attr( $hours ); ?>"
        placeholder="e.g. 08:00 am - 08:00 pm">
</div>
<p class="description">Latitude/Longitude can be found using Google Maps or online coordinate finders.</p>
<?php
    }

    public function save_location_meta( $post_id ) {
        if ( ! isset( $_POST['peachtree_location_nonce'] ) || ! wp_verify_nonce( $_POST['peachtree_location_nonce'], 'peachtree_location_nonce_action' ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $fields = array(
            'map_address' => '_map_address',
            'map_phone'   => '_map_phone',
            'map_rating'  => '_map_rating',
            'map_lat'     => '_map_lat',
            'map_lng'     => '_map_lng',
            'map_hours'   => '_map_hours',
        );

        foreach ( $fields as $post_key => $meta_key ) {
            if ( isset( $_POST[ $post_key ] ) ) {
                update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $post_key ] ) );
            }
        }
    }
}