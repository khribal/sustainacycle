let map;
let infoWindow;


const fixedLocation = {
    lat: 39.173100,
    lng: -86.524239
};

// Move the function definition outside the initMap function
function successCallback(position) {
    const userLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
    };

    // Initialize the map
    map = new google.maps.Map(document.getElementById('map'), {
        center: fixedLocation,
        zoom: 15,
    });

    // Initialize an info window for markers
    infoWindow = new google.maps.InfoWindow();

    // Search for recycling companies by keyword
    initMap(); // Call initMap here after the map is initialized
}

function handlePlacesResults(results, status) {
    console.log('Handle Places Results:', results, status);

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
    // Use the PlacesService to search for recycling centers
    const service = new google.maps.places.PlacesService(map);

    // Define the request for recycling centers
    const request = {
        location: map.getCenter(),
        radius: 5000, // adjust the radius as needed
        keyword: 'restaurant',
    };

    // Perform the nearby search
    service.nearbySearch(request, handlePlacesResults);

    map.setZoom(15);
}


// Error callback function, if needed
function errorCallback(error) {
    console.error('Error getting user location:', error);
}
