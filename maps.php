<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locator</title>
    
    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css"> -->

     <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&libraries=places&loading=async&callback=initMap" defer></script>
          
    <!-- JS -->
    <!-- <script src="js/maps.js"></script> -->

    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body>


      <div id="map"></div>
<!-- 
      <script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM",
    v: "weekly",
  });
</script>
     -->

<script>
// Initialize and add the map
let map;

async function initMap() {
  // The location of Uluru
  const user_position = { lat: 39.172192, lng: -86.519409 };
  // Request needed libraries.
//   @ts-ignore
//   const { Map } = await google.maps.importLibrary("maps");
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  // The map, centered at Uluru
  map = new google.maps.Map(document.getElementById("map"), {
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
          const marker = new google.maps.Marker({
            map,
            position: place.geometry.location,
            title: place.name,
          });
          console.log("Marker created: " + place.geometry.location)
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


// Call the initMap function when the DOM is ready
document.addEventListener("DOMContentLoaded", initMap);

</script>
</body>
</html>