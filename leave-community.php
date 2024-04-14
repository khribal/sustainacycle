<?php
session_start();
$userID = $_SESSION['userID'];

//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
    

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $communityID = $_POST['communityID'];

    $removeUser = "DELETE FROM user_community WHERE userID=$userID AND communityID = $communityID";
    $result = $conn->query($removeUser);
    if ($result === TRUE) {
        // Deletion was successful
        $_SESSION['left_comm'] = true;
        header('Location: user_communities.php');
        exit();
    } else {
        // Deletion failed
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>