<?php session_start(); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //collect form information
    $companyName = $_POST["companyName"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $country = $_POST["country"];

    // Database connection code
    $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
    }
    
    $userID = $_SESSION['userID'];
    
    $insertQuery = "INSERT INTO recyclers (userID, companyName, cAddress, city, cState, zip, country)
    VALUES ('$userID', '$companyName', '$street', '$city', '$state', '$zip', '$country')" ;

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycler Information</title>
    <?php 
        include('../includes/boot-head.php');
        // include('../includes/google-fonts.php');
    ?>
</head>
<body>
<?php 
    include('../includes/login-nav.php');
?>

<div class="container">
        <h1>Please enter your address to complete your registration!</h1>
        <p>We want to ensure that users are easily able to find your recycling center, and by providing the name of your center and address we are able to send more users to your recycling center and increase textile recycling.</p>
        <div class="container">
        <form id="recycler-form" action="recycler.php" method="post">
            <div class="form-group">
                <label for="companyName">Name of your business:</label>
                <input class="form-control" type="text" id="companyName" name="companyName">
            </div>
            <div class="form-group">
                <label for="street">Street:</label>
                <input class="form-control" type="text" id="street" name="street">
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input class="form-control" type="text" id="city" name="city">
            </div>
            
            <div class="form-group">
            <label for="state">State:</label>
                <select class="form-control" name="state" id="state">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
            </div>
        
            <div class="form-group">
                <label for="zip">Zipcode:</label>
                <input class="form-control" type="text" id="zip" name="zip" required><br><br>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <select class="form-control" name="country" id="country">
                    <option value="United States">United States</option>
                    <option value="Canada">Canada</option>
                </select>
            </div>

            <div class="container">
                <input class="btn btn-success" type="submit" value="Submit">
            </div>
        </form>
        </div>
    </div>

<?php 
    include('../includes/login-foot.php');
    include('../includes/boot-script.php');
?>
</body>
</html>