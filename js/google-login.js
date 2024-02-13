function onSignIn(googleUser) {
  // Handle the successful sign-in, such as sending the user's profile information to your server.
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do something with the user's ID
  console.log('Name: ' + profile.getName()); // Do something with the user's name
  console.log('Email: ' + profile.getEmail()); // Do something with the user's email
}
