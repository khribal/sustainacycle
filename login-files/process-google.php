<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--  library jwt-decode to handle JWT decoding -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jwt-decode/3.1.2/jwt-decode.min.js"></script>

</head>
<body>
    <?php
// Check if the POST data is set
    if (isset($_POST['id_token'])) {
    // Get the ID token from the POST data
        $id_token = $_POST['id_token'];

    // Decode the ID token to get user information using json_decode
    $decoded_token = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $id_token)[1])), true);
    
    $user_email = $decoded_token['email'];
    
            // Database connection code
            $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

            //in case it fails
            if (!$con) {
                die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
            }
        
            //check if the user exists already
            $user_email = $decoded_token['email'];

        // Check if the user exists in the database
        $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$user_email'");

        if ($row = mysqli_fetch_assoc($result)) {
            // User exists, proceed with login
            // Use $user_role to customize the user's experience
            session_start(); 
            $_SESSION['userType'] = $row['userType'];
            $_SESSION['username'] = $row['username'];
            //Redirect user back to home page
            header('Location: ../index.php');
            exit();

        } else {
            // User does not exist, redirect to registration page
            header('Location: register.php?email='.$user_email);
            exit();
        }
            
            mysqli_close($con);
        
} else {
    // Handle the case where the POST data is not set
    echo "Error: POST data not received.";
}



?>


</body>
</html>