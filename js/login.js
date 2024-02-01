'use strict';
console.log('Js is working.');

// initialize the Google API client
function initClient() {
    gapi.load('auth2', function() {
        gapi.auth2.init({
        client_id: '936138798104-e109kqpo0rhi60a3pmtgq03l7qm1dlp7.apps.googleusercontent.com'
        });
    });
}

// handle the sign-in process
function onSignIn(googleUser) {
    // get the Google User's ID token, which we need to send to the backend
    var id_token = googleUser.getAuthResponse().id_token;

    if (id_token) {
        fetch('google-login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'idtoken=' + encodeURIComponent(id_token)
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    } else {
        // if 'id_token' is not available
        console.error('ID token not available.');
    }
}



// sign out function
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
}

document.getElementById('googleSignInButton').addEventListener('click', function() {
    gapi.auth2.getAuthInstance().signIn();
});
