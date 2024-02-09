<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locator</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Google Maps API -->

    <!-- <script>
        // Define the initMap function
        function initMap() {
            // Create a map centered at a specific location
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -33.867, lng: 151.195 },
                zoom: 15,
            });

            // You can add additional map-related setup or actions here
        }
    </script> -->


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&loading=async&libraries=places&callback=initMap" async defer></script>
    
    <!-- JS -->
    <!-- <script src="js/maps.js"></script> -->
    <!-- <script src="js/get-location.js"></script> -->
    
    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body>
<?php include('includes/nav.php');?>

      <div id="map"></div>

      <script>
            function initMap() {
            // Create a map centered at a specific location
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -33.867, lng: 151.195 },
                zoom: 15,
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
                                icon: {
                                    url: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png', // Bright red marker icon
                                    size: new google.maps.Size(32, 32),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(16, 32),
                                    scaledSize: new google.maps.Size(32, 32),
                                },
                            });

                            // Do something with each place
                            console.log(place);
                        }
                    }
                }
            );
        }
    </script>

</body>
</html>