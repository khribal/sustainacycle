<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include jwt-decode -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script> -->
</head>
<body>

<?php
// require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_token = $_POST['credential'];
    // echo "Token: " . $id_token . "<br>";

    
    $payload = 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $id_token;
        $json = file_get_contents($payload);
        $userInfoArray = json_decode($json,true);
            //get user values
            $googleEmail = $userInfoArray['email'];
            $googlefName = $userInfoArray['given_name'];    
            $googleLname = $userInfoArray['family_name'];
    }


//CHECK IF THE USER IS REGISTERED
    // Database connection code
    $con = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

    if (!$con) {
        die("Failed to connect to MySQL: " . mysqli_connect_error() . "<br><br>");
    }

// Find their username by their google email

$findUsername = "SELECT * from users where email=$googleEmail"; 
$resultUser = mysqli_query($con, $findUsername);

if($resultUser){
    if($row = mysqli_fetch_assoc($resultUser)){
        $username = $row['username'];
        $usertype = $row['usertype'];
        $userID = $row['userID'];
        $name = $row['firstName'];
            //start the session, and assign user vars
            session_start(); 
            $_SESSION['userID'] = $userID;
            $_SESSION['usertype'] = $usertype;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;

            //set login success flag
            $_SESSION['login_success'] = true; // Set a success flag

            //redirect to index
            header('Location: ../index.php');
            exit();
    }
}
//User is not yet in the database, take them to a page to complete registration
else{
    //send the googleEmail to registration page
    header('Location: google-reg.php?email=' . urlencode($googleEmail) . '&firstName=' . urlencode($googlefName) . '&lastName=' . urlencode($googleLname));
    exit();
}

// if($resultUser){
//     if ($row = mysqli_fetch_assoc($resultUser)) {
//         $username = $row['username'];
//         $usertype = $row['usertype'];
//         $userID = $row['userID'];
//         $name = $row['firstName'];
//             //start the session, and assign user vars
//             session_start(); 
//             $_SESSION['userID'] = $userID;
//             $_SESSION['usertype'] = $usertype;
//             $_SESSION['username'] = $username;
//             $_SESSION['name'] = $name;

//             //set login success flag
//             $_SESSION['login_success'] = true; // Set a success flag

//             //redirect to index
//             header('Location: ../index.php');
//             exit();
//     } else{
//         echo "no account yet";
//     }   
// }


mysqli_close($con);
?>


</body>
</html>
