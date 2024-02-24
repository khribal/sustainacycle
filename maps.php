<html>
  <head>
    <title>Locator</title>

  <!-- Bootstrap -->
  <?php include('./includes/boot-head.php'); ?>

  <!-- Google maps api code-->
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  
  <!-- google maps functions -->
  <!-- <script type="module" src="js/maps.js"></script> -->
  
  <!-- PHP recycler locations -->
  <?php include('./includes/maps-data.php'); ?>

<script>
// Initialize and add the map
let map;
let userPosition;

// Check if the Geolocation API is available and get user location
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    (pos) => {
      userPosition = {
        lat: pos.coords.latitude,
        lng: pos.coords.longitude
      };
    }
  );
}
else{
  //default in case of error
  position = { lat: 39.172192, lng: -86.519409 };
  console.log("Position not found, default used.")
}

//flag to see if map loaded
let mapLoaded = false;

async function initMap() {
  // Request needed libraries.
  //@ts-ignore
  const { Map } = await google.maps.importLibrary("maps", "places");
//   const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  map = new Map(document.getElementById("map"), {
    zoom: 12,
    center: userPosition,
    mapId: "DEMO_MAP_ID",
  });

  
  // Create a PlacesService instance
  const service = new google.maps.places.PlacesService(map);

  //set up variable with recycler addresses from the database
  var concatenatedAddresses = <?php echo $jsonConcatenatedAddresses; ?>;
  console.log(concatenatedAddresses);
  
  // Perform a text search
  service.textSearch(
    {
      query: "recycling center",
      location: userPosition,
      radius: 20000, // Adjust the radius as needed (in meters)
    },
    (results, status) => {
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (const place of results) {
          //only display the results that we have in our database
          if(concatenatedAddresses.includes(place.formatted_address)){
            const placePosition = { lat: place.geometry.location.lat(), lng: place.geometry.location.lng() };
            const marker = new google.maps.Marker({
                position: placePosition,
                map: map,
                title: place.name,
            });

            marker.setVisible(true);
            marker.setMap(map);


          // Add a click event listener to the marker
          addMarkerClickListener(marker, place);
        }
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

        const infoWindow = new google.maps.InfoWindow();

        // Set the content and open the InfoWindow

        infoWindow.setContent(content);
        infoWindow.open(map, marker);
    });
}


window.addEventListener('load', initMap);
</script>

  <!-- Css -->
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
  </head>
  <body>

    <?php include('includes/nav.php') ?>
<div class="container">
    <h1>Textile Recyclers Near You</h1>
    <p>Locate the nearest textile recyclers in your area with our interactive map. Take a step towards sustainable living by finding convenient drop-off points for your textile waste. Our network of recycling centers ensures your clothing contributes to a circular fashion ecosystem, minimizing environmental impact. Explore the map to easily connect with responsible recycling options and make a positive change today.</p>
    <!--The div element for the map -->
    <div id="map"></div>
</div>


<!-- Footer --> 
<?php include('./includes/footer.php'); ?>

<!-- Bootstrap -->
<?php include('./includes/boot-script.php'); ?>

<!-- prettier-ignore -->
    <script>
(g => {
  var h, a, k, p = "The Google Maps JavaScript API",
    c = "google",
    l = "importLibrary",
    q = "__ib__",
    m = document,
    b = window;
  b = b[c] || (b[c] = {});
  var d = b.maps || (b.maps = {}),
    r = new Set,
    e = new URLSearchParams,
    u = () => h || (h = new Promise(async (f, n) => {
    await (a = m.createElement("script"));
    e.set("libraries", [...r, "places", "infowindow"] + ""); // Add "places" to the libraries
    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
    e.set("callback", c + ".maps." + q);
    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
    d[q] = f;
    a.onerror = () => h = n(Error(p + " could not load."));
    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
    m.head.append(a);
  }));
  d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
})({
  key: "AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM",
  v: "weekly",
});

//force the page to reload, for some reason the map wont load otherwise


</script>

  </body>
</html>