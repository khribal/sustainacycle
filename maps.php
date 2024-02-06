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
    <!-- <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&callback=console.debug&libraries=maps,marker&v=beta"></script> -->
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&libraries=places"></script> -->

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcZcRcS3sF91dolcW5Ft5SWBztjbBZYlM&libraries=places&callback=initMap"></script>

    <script src="js/maps.js"></script>
    
    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
  </head>
<body>
<?php include('includes/nav.php');?>


    <!-- <gmp-map center="41.75224304199219,-88.18560791015625" zoom="14" map-id="DEMO_MAP_ID">
      <gmp-advanced-marker position="41.75224304199219,-88.18560791015625" title="My location"></gmp-advanced-marker>
    </gmp-map> -->

    <div id="map"></div>

</body>
</html>