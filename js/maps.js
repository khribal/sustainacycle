// Define global variables
let map;
let infoWindow;

// Get user location
navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

// Create var for user location
function successCallback(position) {
    const userLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
    };

    // Initialize the map
    map = new google.maps.Map(document.getElementById('map'), {
        center: userLocation,
        zoom: 15,  // Adjust the zoom level as needed
    });

    // Initialize an info window for markers
    infoWindow = new google.maps.InfoWindow();

    // Search for recycling companies by keyword
    const service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: userLocation,
        radius: 5000,  // Set your desired search radius in meters.
        keyword: 'recycling center',
    }, handlePlacesResults);
}

function handlePlacesResults(results, status) {
    // Handle the results from the Places API
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        // Process the results, e.g., create markers on the map
        for (const place of results) {
            createMarker(place);
        }
    }
}

function createMarker(place) {
    // Create a marker on the map for each place
    const marker = new google.maps.Marker({
        position: place.geometry.location,
        map: map,
        title: place.name,
    });

    // Add a click event listener to the marker
    marker.addListener('click', function () {
        // Open an info window with place details
        infoWindow.setContent(`
            <div>
                <strong>${place.name}</strong><br>
                Address: ${place.vicinity}<br>
                Rating: ${place.rating || 'N/A'}
            </div>
        `);
        infoWindow.open(map, marker);
    });
}
