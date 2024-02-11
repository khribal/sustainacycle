gapi.load('auth2', function() {
    gapi.auth2.init({
        client_id: '198263467133-7i24c3iaup4pdgdbqiuu7d3sduru7dai.apps.googleusercontent.com',
    });
});

  
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  }