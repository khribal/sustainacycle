<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- Bootstrap -->
    <?php include('../includes/boot-head.php');
    ?>

    <!-- Google Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">


    <!-- Google login -->
    <script src="https://accounts.google.com/gsi/client" async></script>

</head>
<body>
<!-- Nav -->
<?php include('../includes/login-nav.php'); ?>
<?php 
session_start(); 
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
        $lastName = $row['lastName'];
        $userID = $row['userID'];
        $email = $row['email'];
        $profilePic = $row['profilePic'];
        $tele = $row['contactNum'];

        if (password_verify($enteredPassword, $storedPassword)) {
            //Store session variables to customize user experience
            $_SESSION['usertype'] = $userType;
            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['userID'] = $userID;
            $_SESSION['email'] = $email;
            $_SESSION['profilePic'] = $profilePic;
            $_SESSION['tele'] = $tele;

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


<!-- Sign in with google button -->
<div id="g_id_onload"
        data-client_id="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com"
        data-login_uri="https://cgi.luddy.indiana.edu/~klhribal/team20/login-files/handleGoogle.php"
        data-auto_prompt="false">
    </div>
    <div class="g_id_signin"
        data-type="standard"
        data-size="large"
        data-theme="outline"
        data-text="sign_in_with"
        data-shape="rectangular"
        data-logo_alignment="left">
    </div>


<p>Don't have an account yet? <a href="register.php">Register here.</a></p>

</div>
</div>




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