<?php 
session_start();
//get user ID
$userID = $_SESSION['userID'];


// $communityID = '';  // default value
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createPost'])) {
    $communityID = $_POST['communityID'];
}

elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['createBtn'])){
    $communityID = $_POST['communityID'];
    $postTitle = $_POST['postTitle'];
    $postBody = $_POST['postBody'];


    // //db connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());}
    
        //get the current time
        $currentTime = time();
        $currentTimeFormatted = date('Y-m-d H:i:s', $currentTime);

        //insert the post into the db, prepared statement
        $insertPost = $conn->prepare("INSERT INTO posts (title, content, like_count, time_stamp, userID, communityID) VALUES (?, ?, 0, ?, ?, ?)");
        $insertPost->bind_param("ssssi", $postTitle, $postBody, $currentTimeFormatted, $userID, $communityID);
        $insertPostResult = $insertPost->execute();
        $insertPost->close();

        if($insertPostResult){
            header('Location: user_communities.php?community_id=' . $communityID);
            exit();
        }
        else{
            echo "Something went wrong.";
        }
        //close db
        $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create post</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <?php 
        include('./includes/boot-head.php');
        include('./includes/google-fonts.php');
    ?>
    <!-- CSS --> 
    <link rel="stylesheet" href="./css/styles.css" type="text/css">
    <!-- icons link -->
    <script src="https://kit.fontawesome.com/9a3fe9bd1f.js" crossorigin="anonymous"></script>

</head>
<body>
<?php 
include('./includes/nav.php');
?>

<div class="container px-4 mx-auto p-2">
    <a href="user_communities.php?community_id=<?php echo $communityID; ?>"><p>Back to community</p></a>
    <h1 class="com">Create new post</h1>
    <p class="com">Create a new post in the community! Please fill out the following form.</p>
    <form action="post.php" method="post">
        <div>
            <p>Post title:</p>
            <input type="text" name="postTitle">
        </div>
        <div>
            <p>Post content:</p>
            <input type="text" name="postBody">
        </div>
        <input type="hidden" name="communityID" value="<?php echo $communityID; ?>">
        <button type="submit" class="btn btn-success" name="createBtn">Create post</button>
    </form>
</div>



<?php include('./includes/boot-script.php')?>



</body>
</html>