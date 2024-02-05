// import React hooks, jwt-decode library, logo, and CSS for App
import logo from './logo.svg';
import { useEffect, useState } from 'react';
import { jwtDecode } from "jwt-decode";
import './App.css';

function App() {
  // hook for managing user information 
  const [ user, setUser ] = useState({});

  // handles response from Google Sign-In callback
  function handleCallbackResponse(response) {
    console.log("Encoded JWT ID token: " + response.credential);
    // decode the JWT ID token to get user information
    var userObject = jwtDecode(response.credential);
    console.log(userObject);
    // update the state with user information
    setUser(userObject);
    // hide the sign-in button after the user has already signed in
    document.getElementById("signInDiv").hidden = true;
  }

  // handles sign out action
  function handleSignOut(event) {
    // reset user state to empty, effectively signing the user out
    setUser({});
    // show sign in button again once user is logged out
    document.getElementById("signInDiv").hidden = false;
  }

  // useEffect hook to initialize Google Sign-In upon component mount
  useEffect(() => {
    // declare the global google object to avoid linting erros
    /* global google */
    google.accounts.id.initialize({
      client_id: "198263467133-7i24c3iaup4pdgdbqiuu7d3sduru7dai.apps.googleusercontent.com", // set client ID
      callback: handleCallbackResponse // sets callback function for sign-in
    });

    // renders the Google Sign-In button
    google.accounts.id.renderButton(
      document.getElementById("signInDiv"),
      { theme: "outline", size: "large"}
    );

    // prompt the user session for sign-in status
    google.accounts.id.prompt();
  }, []); // blank to run useEffect once
// if we have no user: show sign in button
// if we have a user: show the log out button


  // renders the application UI
  return (
    <div className="App">
      <div id="signInDiv"></div>
      { Object.keys(user).length != 0 && 
        <button onClick={ (e) => handleSignOut(e)} className="btn btn-primary">Sign Out</button>

      }
      
      { user &&
        <div>
          <img src={user.picture}></img>
          <h3>{user.name}</h3>

        </div>
      }
    </div>
  );
}

// export the app component for use in other parts of the application
export default App;
