//Check that geolocation is supported
if (navigator.geolocation) {  
  } else {
    console.log("Geolocation is not supported by this browser.");
  }


// Define options for geolocation
const options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
  };


  let hasLocation = false;

// Request geolocation permission
  if (!hasLocation) {
    navigator.geolocation.getCurrentPosition(geoSuccessCallback, errorCallback, options);
  }


//Access the latitude and longitude
function geoSuccessCallback(position) {
    const latitude = position.coords.latitude;
    const longitude = position.coords.longitude;
  
    console.log("Latitude:", latitude);
    console.log("Longitude:", longitude);

    hasLocation = true;
  }
  
//Handle errors
function errorCallback(error) {
    switch (error.code) {
      case error.PERMISSION_DENIED:
        console.log("User denied the request for Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        console.log("Location information is unavailable.");
        break;
      case error.TIMEOUT:
        console.log("The request to get user location timed out.");
        break;
      case error.UNKNOWN_ERROR:
        console.log("An unknown error occurred.");
        break;
    }
  }
  