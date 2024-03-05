<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <?php 
    include('../includes/boot-head.php');
    // include('../includes/google-fonts.php');
    ?>

    <!-- Google Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">


</head>
<body>
<?php 
    include('../includes/login-nav.php');
?>

<!-- complete registration -->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = $_POST["first-name"];
        $lname = $_POST["last-name"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $phone = $_POST["tele"];
        $userType = $_POST["user_type"];

        //Adjust value format for database 
        if ($userType == 'recycler'){
            $userType = 'recycler';
        } elseif ($userType == 'manu'){
            $userType = 'manufacturer';
        }
        else{
            $userType = 'individual_user';
        }

        //HASH USER PASSWORD
        $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

        // Database connection code
        $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    
        if (!$con) {
            die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
        }
        
        $checkQuery = "SELECT * FROM users WHERE username = '$username'";
        $checkResult = mysqli_query($con, $checkQuery);
    
        if (mysqli_num_rows($checkResult) > 0) {
            // Username already exists, handle accordingly (e.g., show an error message)
            echo "<div class='container'><p style='color: red;'><strong>Username already exists. Please choose a different username.</strong></p></div>";
        }else{
    
        $insertQuery = "INSERT INTO users (firstName, lastName, email, username, pass, contactNum, userType)
        VALUES ('$fname', '$lname', '$email', '$username', '$pass_hashed', '$phone', '$userType')";
    
        $result = mysqli_query($con, $insertQuery);
    
        if (!$result) {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
            exit();
        } else {
            session_start(); 
            //Grab the newly created user ID
            $userID = mysqli_insert_id($con);

            //set session vars for customized experience, same as login.php
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $userType;
            $_SESSION['name'] = $fname;
            $_SESSION['userID'] = $userID;
            
            if($_SESSION['usertype'] == 'recycler'){
                header('Location: recycler.php');
                exit();
            }
            elseif($_SESSION['usertype'] == 'manufacturer'){
                header('Location: manu.php');
                exit();
            }
            else{
            //Redirect user back to LANDING page
            if($_SESSION['usertype'] == 'individual_user'){
                header('Location: ../user-home.php');
                exit();
            }
            }
        }
    
    
        mysqli_close($con);
    }
}
?>


<div class="container">
        <h1>Create an account</h1>
        <form id="register-form" action="register.php" method="post">
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" value="<?php echo $fname; ?>" type="text" id="first-name" name="first-name">
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" value="<?php echo $lname; ?>" type="text" id="last-name" name="last-name">
            <label class="form-label" for="email">Email Address:</label>
            <input class="form-control" value="<?php echo $email; ?>" type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Enter a valid email address" required><br><br>
            <label class="form-label" for="username">Username</label>
            <input class="form-control" value="<?php echo $username; ?>" type="text" id="username" name="username" title="Choose your username" required><br><br>
            <label class="form-label" for="password">Password:</label>
            <input class="form-control" type="text" id="password" name="password" required><br><br>
            <label class="form-label" value="<?php echo $tele; ?>" for="tele">Phone:</label>
            <input class="form-control" type="text" id="tele" name="tele">
            <div class="container">
                <p>Please specify what type of user you are:</p>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="recycler" name="user_type" value="recycler" required>
                    <label class="custom-control-label" for="recycler">Recycling Company</label><br>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="manu" name="user_type" value="manu" required>
                    <label class="custom-control-label" for="manu">Manufacturer</label><br>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="individual" name="user_type" value="individual" required>
                    <label class="custom-control-label" for="individual">Individual User</label>
                </div>
            </div>
            <div class="container">
                <input class="btn btn-success" type="submit" value="Submit">
            </div>
        </form>
</div>


<?php 
    include('../includes/login-foot.php');
    include('../includes/boot-script.php');
    ?>
</body>
</html>