<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php //bootstrap 
    include('../includes/boot-head.php'); ?>
    <title>Complete Registration</title>
</head>
<body>
<?php
//nav bar
include('../includes/login-nav.php');

//Get the google info for this user
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    $googleEmail = $_GET['email'];
    $googleFirst = $_GET['firstName'];
    $googleLast = $_GET['lastName'];
}
?>

<div class="container">
    <h2>Complete Registration</h2>
    <p>Fill out the following form to complete your registration.</p>
   <div class="container">
    <form action="google-reg.php" method="post">
    <label class="form-label" for="first-name">First Name:</label>
            <input class="form-control" type="text" id="first-name" name="first-name" value="<?php echo htmlspecialchars($googleFirst); ?>">
            <label class="form-label" for="last-name">Last Name:</label>
            <input class="form-control" type="text" id="last-name" name="last-name" value="<?php echo htmlspecialchars($googleLast); ?>">
            <label class="form-label" for="tele">Phone:</label>
            <input class="form-control" type="text" id="tele" name="tele">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="text" id="username" name="username" title="Choose your username" required><br><br>

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

    <input class="btn btn-success" type="submit" value="Submit">
    </form>
   </div>
</div>




<?php
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = $_POST["first-name"];
        $lname = $_POST["last-name"];
        $username = $_POST["username"];
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

        // Database connection code
        $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    
        if (!$con) {
            die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
        }
    
    
        $insertQuery = "INSERT INTO users (firstName, lastName, email, username, contactNum, userType)
        VALUES ('$fname', '$lname', '$googleEmail', '$username', '$phone', '$userType')";
    
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



<?php //bootstrap 
include('../includes/login-foot.php');
include('../includes/boot-script.php'); ?>
</body>
</html>