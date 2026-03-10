# Goal: Dynamic Locations with Custom Post Type

## Proposed Changes

### UI Components

#### [MODIFY] [peachtree-location-finder.php](file:///c:/Users/HP/Desktop/emory%20map/peachtree-location-finder.php)

- Register Custom Post Type `peachtree_location`.
- Add Meta Boxes for:
  - Address
  - Phone Number
  - Google Rating
  - Latitude & Longitude (for map markers)
  - Operating Hours
- Update `enqueue_assets` to fetch all `peachtree_location` posts and pass them to `script.js` using `wp_localize_script`.

#### [MODIFY] [assets/js/script.js](file:///c:/Users/HP/Desktop/emory%20map/assets/js/script.js)

- Remove hardcoded `locations` array.
- Use the data passed from PHP (via `wp_localize_script` object) to render locations.

## Verification Plan

### Manual Verification

1.  Verify the "Map Locations" menu appears in WordPress admin.
2.  Add a few test locations with addresses and coordinates.
3.  Refresh the page with the shortcode and verify the new locations appear on the map and sidebar.
4.  Verify that coordinate-based markers are accurate.
