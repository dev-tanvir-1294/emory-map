<?php


if (! defined('ABSPATH')) {
    exit;
}

class Peachtree_Shortcode
{

    public function __construct()
    {
        add_shortcode('peachtree_map', array($this, 'render_shortcode'));
    }


    public function render_shortcode()
    {
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