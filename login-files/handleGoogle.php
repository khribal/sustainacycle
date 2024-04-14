<?php
// require_once __DIR__ . '/../vendor/autoload.php';
session_start(); 

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


// Find the user by their google email
$findUsername = "SELECT * from users where email='$googleEmail'"; 
$resultUser = mysqli_query($con, $findUsername);

//user exists in our databases
if(mysqli_num_rows($resultUser) == 1){
    if($row = mysqli_fetch_assoc($resultUser)){
        $username = $row['username'];
        $usertype = $row['usertype'];
        $userID = $row['userID'];
        $name = $row['firstName'];
        $lastName = $row['lastName'];
        $profilePic = $row['profilePic'];
        $tele = $row['contactNum'];

        //set session vars
            $_SESSION['userID'] = $userID;
            $_SESSION['usertype'] = $usertype;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $googleEmail;
            $_SESSION['profilePic'] = $profilePic;
            $_SESSION['tele'] = $tele;

          
          //Redirect user back to LANDING page
          header('Location: ../index.php');
          exit();
    }
}
// User is not yet in the database, take them to a page to complete registration
else {
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

