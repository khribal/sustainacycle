<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Information</title>
    <?php 
        include('../includes/boot-head.php');
    ?>
</head>
<body>
<?php 
    include('../includes/login-nav.php');
?>
<div class="container">
    <h1>Please enter your address to complete your registration!</h1>
    <p>We want to ensure that recyclers are easily able to find your manufacturing location if necessary, and by providing the name of your center and address we are able to send more users to your location and increase textile recycling.</p>
    
    <div class="container">
        <form id="manu-form" action="manu.php" method="post">
            <label class="form-label" for="companyName">Name of your business:</label>
            <input class="form-control" type="text" id="companyName" name="companyName">
            <label class="form-label" for="street">Street:</label>
            <input class="form-control" type="text" id="street" name="street">
            <label class="form-label" for="city">City:</label>
            <input class="form-control" type="text" id="city" name="city">
            <label class="form-label" for="state">State:</label>
            <input class="form-control" type="text" id="state" name="state" title="Enter your state" required><br><br>
            <label class="form-label" for="zip">Zipcode:</label>
            <input class="form-control" type="text" id="zip" name="zip" required><br><br>
            <div class="container">
                <input class="btn btn-success" type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //collect form information
    $companyName = $_POST["companyName"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];

    // Database connection code
    $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
    }

    //start session so we can use the $_SESSION['userID']
    session_start();
    $userID = $_SESSION['userID'];
    
    
    $insertQuery = "INSERT INTO manufacturers (userID, companyName, cAddress, city, cState, zip)
    VALUES ('$userID', '$companyName', '$street', '$city', '$state', '$zip')" ;

    $result = mysqli_query($con, $insertQuery);

    if (!$result) {
        echo "Error: " . $retrieveQuery . "<br>" . mysqli_error($con);
        exit();
    }
    else{
        $_SESSION['registration_success'] = true; // Set a success flag
        //Redirect user back to home page
        header('Location: ../index.php');
        exit();
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