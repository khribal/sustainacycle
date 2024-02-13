<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- Jquery to pass google login info to php -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Google login files -->
    <meta name="google-signin-client_id" content="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com">
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="https://accounts.google.com/gsi/client" async></script>

    <!--  library jwt-decode to handle JWT decoding -->
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script>

</head>
<body>
<?php include("../includes/nav.php") ?>

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
    jQuery.ajax({
        type: "POST",
        url: "process-google.php", // process user info + put into SQL
        data: {
            id_token: encodedToken, // Add id_token to the data
            name: payload.name,
            email: payload.email,
        },
        success: function (response) {
            console.log(response); // Log the PHP response
            // You can update the webpage with the response here
        },
        error: function (error) {
            console.error("Error:", error);
        }
    });
}

function handleCredentialResponse(response) {
    // console.log("Encoded JWT ID token: " + response.credential);
    // Decode the JWT after the response is received
    decodeJwtResponse(response.credential);
}

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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>