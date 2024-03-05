<?php 
session_start();
//get user ID
$userID = $_SESSION['userID'];


//db connection
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
    

if($_SERVER["REQUEST_METHOD"] == "GET"){
    //UPDATE LIKE COUNT
    if (isset($_GET["postID"]) && isset($_GET["communityID"])) {
        //user clicked like button
        $postID = $_GET["postID"];
        $communityID = $_GET['communityID'];

        //update the like count
        $updateLikeCount = "UPDATE posts SET like_count = like_count + 1 WHERE postID = $postID";

        $resultLike = $conn->query($updateLikeCount);

        header('Location: user_communities.php?community_id=' . $communityID);
        exit();
    }  
}
elseif($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['commentBtn'])) {
        $postID = $_POST['postID'];
        $communityID = $_POST['communityID'];
        $commentContent =$_POST['commentField'];

        //insert comment into the database
        $insertComment = "INSERT INTO comments (comment_content, userID, postID) VALUES ('$commentContent', $userID, $postID)";
        $conn->query($insertComment);

        //reload the page with necessary parameter
        header('Location: user_communities.php?community_id=' . $communityID);
        exit();
    }
}


$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Communities</title>
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

<?php 
    //db connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $communityID = $_GET["community_id"];


    // USER CHOSE A COMMUNITY: DISPLAY THE COMMUNITY PAGE
    if (isset($communityID)){
        //get the posts for this community
        $sqlPosts = "SELECT p.postID, p.title, p.content, p.like_count, u.username from posts as p join users as u on u.userID=p.userID where communityID= $communityID";
        
        //get info about the community to display
        $communityInfo = "SELECT communityName, communityRules, communityDescription, tags from communities where communityID=$communityID";

        //results
        $resultPosts = $conn->query($sqlPosts);
        $resultComm = $conn->query($communityInfo);

        //COMMUNITY HEADING
        if ($resultComm->num_rows > 0) {
            while ($rowComm = $resultComm->fetch_assoc()) {
                echo '<div class="container px-4 mx-auto p-2">
                <h1 class="com">' . $rowComm['communityName'] . '</h1>
                <h4 class="com"> Description: ' . $rowComm['communityDescription'] . '</h4>
                <p class="com">Rules: ' . $rowComm['communityRules'] . '</p>
                <p> Tags: ' . $rowComm['tags'] . '</p>
                <form action="post.php" method="post">
                    <input type="hidden" name="communityID" value="' . $communityID . '">
                    <button class="btn btn-success mb-3" type="submit" name="createPost">Create new post</button>
                </form>';
            }
        }
        echo '<div class="container px-4 mx-auto p-2">
            <h3 class="com">Posts</h3>
                <div class="grid-container">';

        //loop through posts and put them on cards
        if ($resultPosts->num_rows > 0) {
            while ($rowPost = $resultPosts->fetch_assoc()) {
                $postID = $rowPost['postID'];
                
                echo '<div class="grid-item">
                        <h5 class="com">' . $rowPost['title'] . '</h5>
                        <p>' . $rowPost['content'] . '</p>
                        <p class="com">by: ' . $rowPost['username'] . '</p>';
                        
                        // Add comment button
                echo '<form method="post" action="user_communities.php">
                        <input type="hidden" name="communityID" value="' . $communityID . '">
                        <input type="hidden" name="postID" value="' . $postID . '">
                        
                        <a href="user_communities.php?postID=' . $rowPost['postID'] . '&communityID=' . $communityID . ' class="card-link">
                            <i class="fa-regular fa-thumbs-up"></i>' . $rowPost['like_count'] . 
                        '</a>
                        <hr>
                            <input type="text" name="commentField" style="width: 100%" placeholder="Type your comment here">
                            <button type="submit" class="btn btn-success" name="commentBtn">Comment</button>
                        <hr>
                    </form>';
                
                

                //get the comments for this community
                $getComments="SELECT c.comment_content, c.userID, u.username from comments as c join users as u on u.userID=c.userID where postID=$postID";
                $resultComments = $conn->query($getComments);
                while($rowComment=$resultComments->fetch_assoc()){
                    echo '<div class="grid-item mt-1 p-1">
                        <p><strong>' . $rowComment['username'] . ':</strong> </p>
                        <p>' . $rowComment['comment_content'] . '</p>
                        </div>';
                }
                echo '</div>';
            }
        } 
        else {
            echo "No posts available in your community.";
        }
        //close the grid
        echo '</div>';
    }

    //User hasn't chosen a community to view, still BROWSING COMMUNITIES
    elseif(!isset($_GET["communityID"])){
        //find the user's communities
        $findCommunities = "SELECT c.communityID, c.communityName, c.communityDescription
        FROM communities c
        INNER JOIN user_community uc ON c.communityID = uc.communityID
        WHERE uc.userID = $userID";
    
        $resultFind = $conn->query($findCommunities);
    
            //get the communityID's that the user is a part of, display those communities and allow them to "enter" each one by passing community_id var
            if ($resultFind->num_rows > 0) {
                echo '<div class="container px-4 mx-auto p-2">';
                echo '<h1 class="com"> Your Communities </h1>';
                echo '<p class="com">View and enter the communities you have joined.</p>';
                echo '</div>';
                echo '<div class="container px-4 mx-auto p-2">';
                echo '<div class="grid-container">';
                while ($rowComm = $resultFind->fetch_assoc()) {
                    echo '<div class="grid-item">
                    <h2 class="com">' . $rowComm['communityName'] . '</h2>
                    <div>
                        <p>' . $rowComm['communityDescription'] . '</p>
                        <a href="user_communities.php?community_id=' .  $rowComm['communityID'] . '" class="btn btn-success">Go to community</a>
                    </div>
                    </div>';
                }
                echo '</div>';
                echo '</div>';
            }
            //USER NOT IN ANY COMMUNITIES
            else{
                echo "<div class=container mx-auto p-2><h4>You haven't joined any communities yet!</h4><a href='join-community.php'><p>Click here</a> to browse our communities.</p></div>";
            }
    }
        $conn->close();
?>

<?php include('./includes/boot-script.php')?>



</body>
</html>