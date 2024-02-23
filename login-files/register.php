<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <?php 
    include('../includes/boot-head.php');
    include('../includes/google-fonts.php');
    ?>
</head>
<body>
<?php 
    include('../includes/login-nav.php');
?>

<div class="container">
        <h1>Create an account</h1>
        <form id="register-form" action="register.php" method="post">
            <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" id="first-name" name="first-name">
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" id="last-name" name="last-name">
            <label class="form-label" for="email">Email Address:</label>
            <input class="form-control" type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Enter a valid email address" required><br><br>
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="text" id="username" name="username" title="Choose your username" required><br><br>
            <label class="form-label" for="password">Password:</label>
            <input class="form-control" type="text" id="password" name="password" required><br><br>
            <label class="form-label" for="tele">Phone:</label>
            <input class="form-control" type="text" id="tele" name="tele">
            <div class="container">
                <p>Please specify what type of user you are:</p>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="recycler" name="user_type" value="recycler">
                    <label class="custom-control-label" for="recycler">Recycling Company</label><br>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="manu" name="user_type" value="manu">
                    <label class="custom-control-label" for="manu">Manufacturer</label><br>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="individual" name="user_type" value="individual">
                    <label class="custom-control-label" for="individual">Individual User</label>
                </div>
            </div>
            <div class="container">
                <input class="btn btn-success" type="submit" value="Submit">
            </div>
        </form>
</div>

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
            $_SESSION['registration_success'] = true; // Set a success flag
            //Redirect user back to home page
            header('Location: ../index.php');
            exit();
            }
        }
    
    
        mysqli_close($con);
    }
?>

<?php 
    include('../includes/login-foot.php');
    include('../includes/boot-script.php');
    ?>
</body>
</html>