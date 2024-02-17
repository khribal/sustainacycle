<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>User Privacy</title>
</head>

<body>
<?php include('includes/nav.php'); ?>

<div class="container mt-4">
    <h1>Communities</h1>
    <?php
    // Database connection
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

    ?>
    <h1>User Privacy Example</h1>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($logged_in): ?>
        <p>Welcome, <?php echo $_SESSION['user_email';] ?>!</p>
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>

        <form method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
