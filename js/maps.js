// Initialize and add the map
let map;

async function initMap() {
  const position = { lat: 39.172192, lng: -86.519409 };
  // Request needed libraries.
  //@ts-ignore
  const { Map } = await google.maps.importLibrary("maps", "places");
//   const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  map = new Map(document.getElementById("map"), {
    zoom: 15,
    center: position,
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
        for (let place of results) {
            // The markers (REMOVED CONST FROM LINE 30)
            marker = new google.maps.Marker({
                //test new google.maps.latlng
                position: new google.maps.LatLng(place.geometry.location),
                map: map,
                title: place.name,
            });

            marker.setVisible(true);
            marker.setMap(map);

          console.log("Marker created: " + place.geometry.location)
          // Add a click event listener to the marker
        //   addMarkerClickListener(marker, place);
        }
      }
    }
  );
}

window.addEventListener('load', initMap);
