<?php session_start(); ?>
<html>
  <head>
    <title>Locator</title>
    
  <!-- Bootstrap, google fonts-->
  <?php 
    include('./includes/boot-head.php'); 
    include('./includes/google-fonts.php');
  ?>

  <!-- Google maps api code-->
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  
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

          // Store the marker reference in the place object
          place.marker = marker;

          // Add a click event listener to the marker
          addMarkerClickListener(marker, place);
          
          //Add location to the sidebar
          addLocationToSidebar(place, document.getElementById('sidebar'));
        }
      }
    }
  }
);
}


function addMarkerClickListener(marker, place) {
    marker.addListener('click', () => {
        // Set content for the InfoWindow
        const content = `
    <div>
        <h3 class="map">${place.name}</h3>
        <p class="map-mini mb-0"><strong>Address:</strong> ${place.formatted_address || 'N/A'}<br>
        <strong>Rating:</strong> ${place.rating ? place.rating + '&#9733;' : 'N/A'}<p>
    </div>
`;

        const infoWindow = new google.maps.InfoWindow();

        // Set the content and open the InfoWindow

        infoWindow.setContent(content);
        infoWindow.open(map, marker);
    });
}

//add each place to sidebar
function addLocationToSidebar(place, sidebar) {
  var locationDiv = document.createElement('div');
    locationDiv.innerHTML = '<h6 class="map">' + place.name + '</h6>' +
                            '<p class="map">' + place.formatted_address + '</p>' +
                            '<hr>';
    
                            // Add a click event listener to the sidebar element
    locationDiv.addEventListener('click', () => {
            // Trigger click event for the corresponding marker
            google.maps.event.trigger(place.marker, 'click');

            // Toggle 'active' class for the clicked sidebar element
            locationDiv.classList.toggle('active');
        });
    
    // Append the new div to the sidebar
    sidebar.appendChild(locationDiv);
}
    


window.addEventListener('load', initMap);
</script>

<!-- STYLE FOR SIDEBAR (for some reason it will only work if i manually put this style here) 
pls modify as needed-->
<style>
  .custom-scroll-container {
    max-height: 400px; /* Set the maximum height as needed */
    overflow-y: auto;
  }

  #sidebar > div:hover {
    background-color: var(--lightblue);
}

</style>

  <!-- Css -->
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
  </head>
  <body>

    <?php include('includes/nav.php') ?>

    <div class="container px-4 mx-auto p-1">
      <h1 class="map">Recylcing Locations</h1>
      <p class="map-lead">See the nearest textile recyclers in your area and request to drop off any of your textile waste.</p>
    </div>

<div class="container px-4 mx-auto p-1">
    <h2 class="map">Textile Recyclers Near You</h1>
    <p class="map">Locate the nearest textile recyclers in your area with our interactive map. Take a step towards sustainable living by finding convenient drop-off points for your textile waste. Our network of recycling centers ensures your clothing contributes to a circular fashion ecosystem, minimizing environmental impact. Explore the map to easily connect with responsible recycling options and make a positive change today.</p>
    <!--The div element for the map -->
    <div class="container">
        <div class="row">
          <div class="col-9">
            <div id="map"></div>
          </div>
          <div class="col">
            <div id="sidebar" class="custom-scroll-container">
              <h5 class="map">Recycling Centers Near You</h5>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="container px-4 mx-auto p-1">
  <h2 class="comm map">Request Drop-Off</h1>
  <p class="map">Request one of your local recyclers to drop off any of your textile waste.</p>
<div class="container pt-0">
  <form action="maps.php" method="POST">
  <input type="text" name="material" id="material" placeholder="Material type" required>
  <input type="text" name="quantity" id="quantity" placeholder="Quantity (lbs)" required>
  <?php 
   //db connection
   $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
   }

   $recyclerSQL= "SELECT companyName from recyclers";
   $result = $conn->query($recyclerSQL);
   echo '<select name="recyclerDropdown" id="recyclerDropdown">';

    // Loop through the results
    while ($row = $result->fetch_assoc()) {
        // Output an option for each result
        echo '<option value="' . $row['companyName'] . '">' . $row['companyName'] . '</option>';
    }
    // Close the select element
    echo '</select>';
    // Free the result set
    $result->free();
  //close db
  $conn->close();
  ?>
  <div><button type="submit" class="btn btn-success" name="submitRequest">Submit request</button></div>
  </form>
  </div>
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