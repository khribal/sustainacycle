// Initialize and add the map
let map;

async function initMap() {
  // The location of Uluru
  const user_position = { lat: 39.172192, lng: -86.519409 };
  // Request needed libraries.
  //@ts-ignore
  const { Map } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  // The map, centered at Uluru
  map = new Map(document.getElementById("map"), {
    zoom: 15,
    center: user_position,
    mapId: "DEMO_MAP_ID",
  });

  // Create a PlacesService instance
  const service = new google.maps.places.PlacesService(map);

  // Perform a text search
  service.textSearch(
    {
      query: "recycling center",
      // You can add more parameters if needed
    },
    (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (const place of results) {
          // Use a red marker
          const marker = new AdvancedMarkerElement({
            map,
            position: place.geometry.location,
            title: place.name,
          });

          // Add a click event listener to the marker
          addMarkerClickListener(marker, place);
        }
      }
    }
  );

  // Function to add click event listener to a marker
  function addMarkerClickListener(marker, place) {
    console.log('Marker Click Event Triggered');
    marker.addListener('click', () => {
      // Set content for the InfoWindow
      const content = `
        <div>
          <strong>${place.name}</strong><br>
          Address: ${place.formatted_address || 'N/A'}<br>
          Rating: ${place.rating || 'N/A'}
        </div>
      `;

      // TODO: Open InfoWindow or do something with the content
    });
  }
}

initMap();
