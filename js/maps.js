// Define a function to load the Google Maps JavaScript API script
function loadGoogleMapsScript() {
  return new Promise((resolve, reject) => {
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places'; // Add any additional libraries you need
    script.onload = resolve;
    script.onerror = reject;
    document.head.appendChild(script);
  });
}

// Initialize and add the map
let map;

async function initMap() {
  const position = { lat: 39.172192, lng: -86.519409 };
  // Request needed libraries.
  //@ts-ignore
  const { Map } = await google.maps.importLibrary("maps", "places");
  //   const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  map = new Map(document.getElementById("map"), {
    zoom: 12,
    center: position,
    mapId: "DEMO_MAP_ID",
  });


  // Create a PlacesService instance
  const service = new google.maps.places.PlacesService(map);

  // Perform a text search


  service.textSearch(
    {
      query: "recycling center",
    },
    (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (const place of results) {

          const placePosition = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };
          const marker = new google.maps.Marker({
            position: placePosition,
            map: map,
            title: place.name,
          });

          marker.setVisible(true);
          marker.setMap(map);

          //   console.log("Marker created: " + place.geometry.location.lat())



          // Add a click event listener to the marker
          addMarkerClickListener(marker, place);
        }
      }
    }
  );
}

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
    // console.log(content);

    const infoWindow = new google.maps.InfoWindow();

    // Set the content and open the InfoWindow

    infoWindow.setContent(content);
    infoWindow.open(map, marker);
  });
}


window.addEventListener('load', initMap);
