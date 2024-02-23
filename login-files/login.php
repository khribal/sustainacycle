<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- Jquery to pass google login info to php -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap -->
    <?php include('../includes/boot-head.php'); ?>

    <!-- Google login files -->
    <meta name="google-signin-client_id" content="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com">
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <script src="https://accounts.google.com/gsi/client" async></script>

    <!--  library jwt-decode to handle JWT decoding -->
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script>

</head>
<body>
<!-- Nav -->
<?php include('../includes/login-nav.php'); ?>

<div class="container">
<div class="mb-3">
    <h1 class="log-in">Log in to your account</h1>

    <form id="login-form" action="login.php" method="post">
        <label class="form-label" for="username">Username:</label>
        <input class="form-control" type="text" id="username" name="username" required><br><br>
        <label class="form-label" for="password">Password:</label>
        <input class="form-control" type="password" id="password" name="password" required><br><br>
        <input class="btn btn-primary mb-3" type="submit" value="Submit">
    </form>

<!--Render button-->
<script>
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
</div>
<?php 
//VERIFY USER CREDENTIALS - CUSTOM LOGIN
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
        $userType = $row['usertype'];
        $name = $row['firstName'];
        $userID = $row['userID'];

        if (password_verify($enteredPassword, $storedPassword)) {
            session_start(); 

            //Store session variables to customize user experience
            $_SESSION['usertype'] = $userType;
            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['userID'] = $userID;
            //set login success flag
            $_SESSION['login_success'] = true; // Set a success flag

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

<!-- Bootstrap and footer -->
<?php 
include('../includes/login-foot.php');
include('../includes/boot-script.php'); ?>

</body>
</html>