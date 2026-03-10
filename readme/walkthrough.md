# Walkthrough: Peachtree Med Location Finder Recreation

I have successfully recreated the "Map Care Center" (Location Finder) from the Peachtree Med website.

## Key Features Implemented

- **Dynamic Data (CPT)**: locations are now managed via a custom "Map Locations" menu in your WordPress dashboard. No more editing code to add venues!
- **Custom Meta Fields**: Each location has dedicated fields for Address, Phone, Google Rating, Map Coordinates (Lat/Lng), and Hours.
- **Shortcode Integration**: Use `[peachtree_map]` anywhere. The plugin automatically fetches all published locations and renders them on the map.
- **Theme-Safe Design**: CSS is encapsulated within the plugin wrapper to avoid style bleeding.
- **Auto-Syncing Map**: The map automatically adjusts its zoom level to show all markers added via the backend.

## Files Created

- [index.html](file:///c:/Users/HP/Desktop/emory%20map/index.html): Defines the structure of the application.
- [index.css](file:///c:/Users/HP/Desktop/emory%20map/index.css): Contains the full styling and design system.
- [index.js](file:///c:/Users/HP/Desktop/emory%20map/index.js): Handles map initialization and basic interactions.

## How to Use Dynamic Locations

1.  **Activate Plugin**: Ensure "Peachtree Location Finder" is active.
2.  **Add Locations**: Go to the brand new **Map Locations** menu in your WordPress sidebar.
3.  **Enter Details**: Add a new location, enter the title (Location Name), and fill in the "Location Details" box (Address, Phone, etc.).
4.  **Publish**: Hit publish. The location will immediately appear on any page using the `[peachtree_map]` shortcode.

> [!TIP]
> To find Latitude and Longitude for a site, right-click any spot on Google Maps, and the coordinates will appear!
