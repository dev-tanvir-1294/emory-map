document.addEventListener("DOMContentLoaded", () => {
  // Constants & State
  const INITIAL_CENTER = [33.95, -84.35];
  const INITIAL_ZOOM = 10;
  let activeMarker = null;

  // Initialize Map
  const map = L.map("map", {
    scrollWheelZoom: false,
    zoomControl: false,
  }).setView(INITIAL_CENTER, INITIAL_ZOOM);

  // Add Zoom Control to Top Right
  L.control.zoom({ position: "topright" }).addTo(map);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  const locations =
    typeof peachtreeLocations !== "undefined" ? peachtreeLocations : [];
  const locationList = document.getElementById("location-list");

  // Custom Icon
  const customIcon = L.divIcon({
    className: "custom-div-icon",
    html: `<div style="background-color: #c8102e; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.3);"></div>`,
    iconSize: [12, 12],
    iconAnchor: [6, 6],
  });

  function renderLocations(data) {
    if (!locationList) return;
    locationList.innerHTML = "";
    const markers = [];

    if (data.length === 0) {
      locationList.innerHTML = `<div style="padding: 40px; text-align: center; color: #64748b;">
                <i class="fa fa-map-marker-alt" style="font-size: 40px; margin-bottom: 20px; opacity: 0.2;"></i>
                <p>No locations found. Please add them in the Map Locations menu.</p>
            </div>`;
      return;
    }

    data.forEach((loc, index) => {
      if (!loc.lat || !loc.lng) return;

      // Create Marker
      const marker = L.marker([loc.lat, loc.lng], { icon: customIcon }).addTo(
        map,
      );
      marker.bindPopup(`
                <div style="padding: 5px;">
                    <b style="font-size: 16px; display: block; margin-bottom: 5px;">${loc.name}</b>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">${loc.address}</p>
                </div>
            `);
      markers.push(marker);

      // Create Premium Sidebar Card
      const card = document.createElement("div");
      card.className = "location-card";
      card.style.animationDelay = `${index * 0.1}s`; // Staggered entry

      // card.innerHTML = `
      //           <div class="rating-badge">
      //               <i class="fa fa-star"></i> ${loc.rating || "5.0"}
      //           </div>
      //           <h3>${loc.name}</h3>
      //           <div class="info-row">
      //               <i class="fa fa-map-marker-alt"></i>
      //               <span>${loc.address}</span>
      //           </div>
      //           <div class="info-row">
      //               <i class="fa fa-phone"></i>
      //               <a href="tel:${loc.phone}">${loc.phone}</a>
      //           </div>
      //           <div class="info-row">
      //               <i class="fa fa-clock"></i>
      //               <span>${loc.hours}</span>
      //           </div>

      //           <div class="time-slots-container">
      //               <div class="time-slots-title">Available Tomorrow</div>
      //               <div class="slots-grid">
      //                   <div class="slot-btn">08:30 AM</div>
      //                   <div class="slot-btn">09:15 AM</div>
      //                   <div class="slot-btn">+ MORE</div>
      //               </div>
      //           </div>

      //           <button class="btn btn-primary" style="width: 100%; margin-top: 20px; justify-content: center;">
      //               Book Appointment
      //           </button>
      //       `;

      card.innerHTML = buildLocationCardHTML(loc, index);

      card.addEventListener("click", () => {
        // Handle UI state
        document
          .querySelectorAll(".location-card")
          .forEach((c) => c.classList.remove("active"));
        card.classList.add("active");

        // Handle Map state
        map.flyTo([loc.lat, loc.lng], 15, {
          duration: 1.5,
          easeLinearity: 0.25,
        });
        marker.openPopup();
      });

      locationList.appendChild(card);
    });

    // Fit map to markers
    if (markers.length > 0) {
      const group = new L.featureGroup(markers);
      map.fitBounds(group.getBounds(), { padding: [50, 50] });
    }
  }

  // Use My Location
  const locateBtn = document.getElementById("use-my-location");
  if (locateBtn) {
    locateBtn.addEventListener("click", () => {
      map.locate({ setView: true, maxZoom: 16 });
    });

    map.on("locationfound", (e) => {
      L.circle(e.latlng, e.accuracy).addTo(map);
    });

    map.on("locationerror", () => {
      alert("Could not access your location.");
    });
  }

  function buildLocationCardHTML(loc, index) {
    return `
    <div class="rating-badge">
        <i class="fa fa-star"></i> ${loc.rating || "5.0"}
    </div>
    <h3>${loc.name}</h3>
    <div class="info-row">
        <i class="fa fa-map-marker-alt"></i>
        <span>${loc.address}</span>
    </div>
    <div class="info-row">
        <i class="fa fa-phone"></i>
        <a href="tel:${loc.phone}">${loc.phone}</a>
    </div>
    <div class="info-row">
        <i class="fa fa-clock"></i>
        <span>${loc.hours}</span>
    </div>
    
    <div class="time-slots-container">
        <div class="time-slots-title">Available Tomorrow</div>
        <div class="slots-grid">
            <div class="slot-btn">08:30 AM</div>
            <div class="slot-btn">09:15 AM</div>
            <div class="slot-btn">+ MORE</div>
        </div>
    </div>
    
    <button class="btn btn-primary" style="width: 100%; margin-top: 20px; justify-content: center;">
        Book Appointment
    </button>
  `;
  }

  // Initial Render
  renderLocations(locations);

  // Resize handler
  window.addEventListener("resize", () => {
    map.invalidateSize();
  });

  // Final map refresh after load
  setTimeout(() => {
    map.invalidateSize();
  }, 500);
});
