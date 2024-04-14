<?php
session_start();
$userID = $_SESSION['userID'];

//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $postID = $_POST['postID'];
    $communityID = $_POST['communityID'];

    echo $postID;
    echo $communityID;

    $deletePost = "DELETE from posts where postID=$postID";
    $result = $conn->query($deletePost);

    if ($result === TRUE) {
        // Deletion was successful
        $_SESSION['delete_post'] = true;
        header('Location: user_communities.php?community_id=' . $communityID);
        exit();
    } else {
        // Deletion failed
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>