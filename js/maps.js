function googleMapsApiError() {
    console.error('Error loading Google Maps API.');
 } 

//Global var for info window
let infoWindow;


// Call initMap here
function initMap() {
    // Create a map centered at a specific location
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 39.173100, lng: -86.524239 },
        zoom: 15,
    });

    // Create a PlacesService instance
    const service = new google.maps.places.PlacesService(map);

    // Create an InfoWindow
    // Do not redeclare infoWindow here


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
                        // icon: {
                        //     url: 'https://maps.google.com/mapfiles/ms/micons/red-dot.png', // Bright red marker icon
                        //     size: new google.maps.Size(32, 32),
                        //     origin: new google.maps.Point(0, 0),
                        //     anchor: new google.maps.Point(16, 32),
                        //     scaledSize: new google.maps.Size(32, 32),
                        // },
                    });

                    console.log('Marker created:', marker);

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
            // console.log(content);
            infoWindow = new google.maps.InfoWindow();
            // Set the content and open the InfoWindow
            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        });
    }
}

google.maps.event.addDomListener(window, 'load', initMap);
