# Peachtree Location Finder

A lightweight **WordPress Location Finder Plugin** that allows administrators to create and display locations on an interactive map with a searchable sidebar.

The plugin uses **Leaflet.js** to render maps and provides a simple **shortcode-based integration** for displaying locations on any page.

---

# Features

* Custom Post Type for managing locations
* Interactive **Leaflet.js map**
* Search by address or ZIP code
* "Use My Location" geolocation feature
* Sidebar with location listings
* Marker synchronization with sidebar items
* Optimized asset loading
* Shortcode support
* Modular plugin architecture for easy extension

---

# Plugin Structure

```
peachtree-location-finder/
│
├── peachtree-location-finder.php
│
├── includes/
│   ├── class-peachtree-cpt.php
│   ├── class-peachtree-shortcode.php
│   └── class-peachtree-assets.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   └── js/
│       └── script.js
│
└── readme/
    ├── implementation_plan.md
    └── walkthrough.md
```

---

# Installation

1. Download the plugin ZIP file.

2. Upload it to your WordPress plugins directory:

```
wp-content/plugins/
```

3. Activate the plugin from:

```
WordPress Dashboard → Plugins
```

---

# Usage

## 1. Add Locations

Navigate to:

```
Dashboard → Map Locations
```

Create a new location and add:

* Title
* Address
* Latitude
* Longitude
* Other location details

Publish the location.

---

## 2. Display the Map

Add the shortcode to any page or post:

```
[peachtree_map]
```

Example page:

```
Find Our Locations
```

Once the shortcode is added, the plugin will automatically display:

* Search field
* Location sidebar
* Interactive map

---

# Shortcode

```
[peachtree_map]
```

Displays:

* Search bar
* Sidebar with locations
* Interactive map with markers

---

# How It Works

### 1. Custom Post Type

The plugin registers a custom post type called:

```
Map Locations
```

Each location is stored as a post with custom metadata.

---

### 2. Location Metadata

Each location stores additional data such as:

* Address
* Latitude
* Longitude
* Contact details

This data is saved using **WordPress post meta**.

---

### 3. Map Rendering

The plugin uses:

```
Leaflet.js
```

Leaflet is a lightweight JavaScript library used to render maps and location markers.

---

### 4. Geolocation

Users can click:

```
Use My Location
```

The plugin will request browser permission and use the **Geolocation API** to find the user’s location and display nearby markers.

---

# Assets Used

## CSS

```
assets/css/style.css
```

Handles layout and styling of:

* Map container
* Sidebar
* Search section
* Location cards

---

## JavaScript

```
assets/js/script.js
```

Handles:

* Map initialization
* Marker creation
* Sidebar interaction
* Search functionality
* Geolocation

---

# Performance Optimization

The plugin loads scripts **only when the shortcode is present**.

```
has_shortcode()
```

This prevents unnecessary assets from loading on other pages.

---

# Developer Architecture

The plugin follows a **modular class-based structure**.

### Main Plugin Class

```
Peachtree_Location_Finder_Main
```

Responsible for:

* Loading modules
* Defining constants
* Bootstrapping the plugin

---

### CPT Module

```
Peachtree_CPT
```

Handles:

* Registering custom post type
* Meta boxes
* Saving location data

---

### Shortcode Module

```
Peachtree_Shortcode
```

Handles:

* Registering the shortcode
* Rendering the frontend layout

---

### Assets Module

```
Peachtree_Assets
```

Handles:

* CSS and JS loading
* Third-party library loading

---

# Dependencies

The plugin uses the following libraries:

### Leaflet.js

Used for map rendering.

https://leafletjs.com/

---

### Font Awesome

Used for UI icons.

https://fontawesome.com/

---

# Future Improvements

Possible enhancements:

* AJAX-based location search
* Distance calculation
* Location categories (hospital, clinic, pharmacy)
* REST API support
* Gutenberg block integration
* Google Maps support as an alternative
* Marker clustering for large datasets

---

# Example Use Cases

This plugin can be used for:

* Store locators
* Hospital finder
* Pharmacy locator
* Restaurant location map
* Company branch locator

---

# Author

**Tanvir Ahmed**

Portfolio
https://dev-tanvir-1294.github.io/portfolio/

---

# License

GPL v2 or later

This plugin is open-source and can be modified and redistributed under the GPL license.
