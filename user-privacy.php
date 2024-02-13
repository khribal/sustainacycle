<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>See Available Waste</title>
</head>
<body>

<?php include('includes/nav.php') ?>

<div class="jumbotron">
  <div class="container">
    <h4>See what materials manufacturers have available to be recycled right now!</h4>
  </div>
</div>

<?php
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }


    // authentication function //

    function authenticateUser($email, $password) {
        global $users;
        if (isset($users[$email]) && password_verify($password, $users[$email]['password'])) {
            return true;
        }
        return false;
    }

    // check if user logged in //
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (authenticateUser($email, $password)) {
            $_SESSION['user_email'] = $email;
            $message = "Login Successful.";
        } else {
            $error = "Invalid email or password.";
        }
    }

    //check if user logged out //
    if (isset($_POST['logout'])) {
        session_destroy();
        $message = "Logout Successful.";
    }

