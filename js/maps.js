// Initialize and add the map
let map;

function initMap() {
  // The location of the user
  const position_user = { lat: 39.172190, lng: -86.519410 };
  // Import map and marker
  //@ts-ignore
//   const { Map } = await google.maps.importLibrary("maps");
//   const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  // Create the map
  map = new Map(document.getElementById("map"), {
    zoom: 15,
    center: position_user,
    // mapId: "DEMO_MAP_ID",
  });

  // Text search for recycling centers
  const service = new google.maps.places.PlacesService(map);

  service.textSearch(
    {
      query: "recycling center",
      // You can add more parameters if needed
    },
    (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        console.log('Before loop');
        for (const place of results) {
          // Create markers for each place
          const marker = new google.maps.Marker({
            map,
            position: place.geometry.location,
            title: place.name,
          });

          addMarkerClickListener(marker, place);
        }
        console.log('After loop');
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

// Call the initMap function
// initMap();
