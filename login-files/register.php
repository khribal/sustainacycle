<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
</head>
<body>
<div class="form-container">
        <h1>Create an account</h1>
        <form id="register-form" action="register.php" method="post">
            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name">
            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Enter a valid email address" required><br><br>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" title="Choose your username" required><br><br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required><br><br>
            <label for="tele">Phone:</label>
            <input type="text" id="tele" name="tele">
            <p>Please specify what type of user you are:</p>
                <input type="radio" id="recycler" name="user_type" value="recycler">
                <label for="recycler">Recycling Company</label><br>
                <input type="radio" id="manu" name="user_type" value="manu">
                <label for="manu">Manufacturer</label><br>
                <input type="radio" id="individual" name="user_type" value="individual">
                <label for="individual">Individual User</label>

            <input type="submit" value="Submit">
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

        //Adjust values for database 
        if ($userType == 'Recycling company'){
            $userType = 'recycler'
        } elseif ($userType == 'Manufacturer'){
            $userType = 'manufacturer'
        }
        else{
            $userType = 'individual_user'
        }

        //!!! ADD PASSWORD ENCRYPTION HERE //

        // Database connection code
        $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    
        if (!$con) {
            die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
        }
    
    
        $insertQuery = "INSERT INTO users (firstName, lastName, email, username, pass, contactNum, userType)
        VALUES ('$fname', '$lname', '$email', '$username', '$pass', '$phone', '$userType')";
    
        $result = mysqli_query($con, $insertQuery);
    
        if (!$result) {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
            exit();
        } else {
            session_start(); 
            $_SESSION['username'] = $username;
            //Redirect user back to home page
            header('Location: ../index.php');
            exit();
        }
    
    
        mysqli_close($con);
    }
?>
</body>
</html>