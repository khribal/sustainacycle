<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- Jquery to pass google login info to php -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->

    <!-- Google login files -->
    <meta name="google-signin-client_id" content="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com">
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="https://accounts.google.com/gsi/client" async></script>

    <!--  library jwt-decode to handle JWT decoding -->
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script>

</head>
<body>

<div class="form-container">
    <h1 class="log-in">Log in to your account</h1>

    <form id="login-form" action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Submit">
    </form>




<!-- Pass information from google login to process-google.php -->
<script>
    function decodeJwtResponse(encodedToken) {
        const base64Url = encodedToken.split('.')[1];
        const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        const jsonPayload = decodeURIComponent(atob(base64).split('').map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)).join(''));
        const payload = JSON.parse(jsonPayload);
        $.ajax({
            type: "POST",
            url: "https://cgi.luddy.indiana.edu/~team20/login-files/login.php",
            data: JSON.stringify({
                id_token: encodedToken,
                name: payload.name,
                email: payload.email,
            }),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            //return the data instead of logging success
            success: function (response) {
                console.log("Success, google processing begun.");
                console.log(data);
                // console.log(data);
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
}

//use a variable to test this function, pass to php
function handleCredentialResponse(response) {
    // console.log("Encoded JWT ID token: " + response.credential);
    // Decode the JWT after the response is received
    decodeJwtResponse(response.credential);
}

//!!!!!!!!!!!!!!!!!!!!!!!!
//executing everytime the page loads
window.onload = function () {
    google.accounts.id.initialize({
        client_id: "605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });
    google.accounts.id.renderButton(
        document.getElementById("buttonDiv"),
        { theme: "outline", size: "large" }  // customization attributes
    );
    google.accounts.id.prompt(); // also display the One Tap dialog
}
</script>


<!-- Sign in with google button -->
    <div id="buttonDiv"></div>

</div>


<?php 
//verify user credentials
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Database connection code
    $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
    }


    //retrieve password
    $retrieveQuery = "SELECT * FROM users WHERE username = '$user'";
    $result = mysqli_query($con, $retrieveQuery);

    if (!$result) {
        echo "Error: " . $retrieveQuery . "<br>" . mysqli_error($con);
        exit();
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $storedPassword = $row['pass'];

        //get the userType for customized experience
        $userType = $row['userType'];

        //!!! USE THE LINE BELOW ONCE PASSWORDS ARE HASHED!!!
        //password_verify($enteredPassword, $storedPassword

        if ($enteredPassword == $storedPassword) {
            session_start(); 
            $_SESSION['userType'] = $userType;
            $_SESSION['username'] = $user;
            //Redirect user back to home page
            header('Location: ../index.php');
            exit();
        } else {
            echo '<div style="text-align: center; color: red; font-size: 16px; font-weight: bold;">Incorrect password. Please try again.</div>';
        }
    } else {
        echo '<div style="text-align: center; color: red; font-size: 16px; font-weight: bold;">User not found. Please check your email or <a href="register.php">register</a> for an account.</div>';
    }

    mysqli_close($con);
} else {
    if (isset($_POST['id_token'])) {
        // Get the ID token from the POST data    
        $id_token = $_POST['id_token'];
    
        // Decode the ID token to get user information using json_decode
        $request = json_decode($id_token);

        // Extract information from the decoded JSON data
        $id_token = $request->id_token;
        $name = $request->name;
        $email = $request->email;
        // Decode the ID token to get user information using json_decode
        // $decoded_token = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $id_token)[1])), true);
        
        // $user_email = $decoded_token['email'];
        
                // Database connection code
                $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    
                //in case it fails
                if (!$con) {
                    die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
                }
            
                //check if the user exists already
                // $user_email = $decoded_token['email'];
    
            // Check if the user exists in the database
            $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$user_email'");
    
            if ($row = mysqli_fetch_assoc($result)) {
                // User exists, proceed with login
                // Use $user_role to customize the user's experience
                session_start(); 
                $_SESSION['userType'] = $row['userType'];
                $_SESSION['username'] = $row['username'];
                //Redirect user back to home page
                header('Location: ../index.php');
                exit();
    
            } else {
                // User does not exist, redirect to registration page
                // header('Location: register.php?email='.$user_email);
                // exit();
                echo "User not in database";
            }
                
                mysqli_close($con);
            
    } else {
        // Handle the case where the POST data is not set
        echo "Error: POST data not received.";
    }
}


?>


<!-- <script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script> -->

<!-- Bootstrap -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

</body>
</html>