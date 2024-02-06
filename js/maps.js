// Define global variables
let map;
let infoWindow;

// Move the function definition outside the initMap function
function successCallback(position) {
    const userLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
    };

    // Initialize the map
    map = new google.maps.Map(document.getElementById('map'), {
        center: userLocation,
        zoom: 15,
    });

    // Initialize an info window for markers
    infoWindow = new google.maps.InfoWindow();

    // Call initMap when the map is ready
    initMap();
}

function handlePlacesResults(results, status) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        for (const place of results) {
            createMarker(place);
        }
    }
}

function createMarker(place) {
    const marker = new google.maps.Marker({
        position: place.geometry.location,
        map: map,
        title: place.name,
    });

    marker.addListener('click', function () {
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

function initMap() {
    // Search for recycling companies by keyword
    console.log('initMap called');

    const service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: map.getCenter(),
        radius: 5000,
        keyword: 'recycling center',
    }, handlePlacesResults);
}

// Get user location
navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

// Error callback function, if needed
function errorCallback(error) {
    console.error('Error getting user location:', error);
}
