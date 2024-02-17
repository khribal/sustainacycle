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

  const marker = new google.maps.Marker({
    position: position,
    map: map,
    title: 'Marker Title'
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
            const marker = new google.maps.Marker({
                position: { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() },
                map: map,
                title: place.name,
            });

            marker.setVisible(true);
            marker.setMap(map);

          console.log("Marker created: " + place.geometry.location.lat())



          // Add a click event listener to the marker
        //   addMarkerClickListener(marker, place);
        }
      }
    }
  );
}

window.addEventListener('load', initMap);
