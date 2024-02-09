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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&loading=async&libraries=places&callback=initMap" async defer></script>
    
    <!-- JS -->
    <script src="js/maps.js"></script>
    <!-- <script src="js/get-location.js"></script> -->
    
    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body>
<?php include('includes/nav.php');?>

      <div id="map"></div>

      <!-- <script>
            //Global var for info window
            let infoWindow;


            function initMap() {
            // Create a map centered at a specific location
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 39.173100, lng: -86.524239 },
                zoom: 15,
            });

            // Create a PlacesService instance
            const service = new google.maps.places.PlacesService(map);

            // Create an InfoWindow
            const infoWindow = new google.maps.InfoWindow();

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
                                    size: new google.maps.Size(64, 64),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(16, 32),
                                    scaledSize: new google.maps.Size(64, 64),
                                },
                            });

                            // Add a click event listener to the marker
                            addMarkerClickListener(marker, place);
                            // Do something with each place
                            console.log(place);
                        }
                    }
                }
            );
            // Function to add click event listener to a marker
        function addMarkerClickListener(marker, place) {
            marker.addListener('click', () => {
                // Set content for the InfoWindow
                const content = `
                    <div>
                        <strong>${place.name}</strong><br>
                        Address: ${place.formatted_address || 'N/A'}<br>
                        Rating: ${place.rating || 'N/A'}
                    </div>
                `;
                
                // Set the content and open the InfoWindow
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
            });
        }
        }
    </script> -->

</body>
</html>