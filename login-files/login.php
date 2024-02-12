<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>


    <!-- Google login files -->
    <meta name="google-signin-client_id" content="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    
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


    <div class="g-signin2" data-onsuccess="onSignIn"></div>

<a href="#" onclick="signOut();">Sign out</a>

<script src="../js/google-login.js"></script>

</div>


<?php 

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

        //!!! USE THE LINE BELOW ONCE PASSWORDS ARE HASHED!!!
        //password_verify($enteredPassword, $storedPassword

        if ($enteredPassword == $storedPassword) {
            session_start(); 
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

<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>


</body>
</html>