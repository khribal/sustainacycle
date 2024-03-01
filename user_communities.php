<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Communities</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <?php include('./includes/boot-head.php')?>
    <!-- CSS --> 
    <link rel="stylesheet" href="css/styles.css">
    <!-- icons link -->
    <script src="https://kit.fontawesome.com/9a3fe9bd1f.js" crossorigin="anonymous"></script>

</head>
<body>
<?php 
include('./includes/nav.php');

// if (isset($_GET["community_id"])) {
//     $communityID = $_GET["community_id"];
// }
?>    

<?php 
    //db connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    session_start();
    //get user ID
    $userID = $_SESSION['userID'];
    $communityID = $_GET["community_id"];


    // User clicked on a specific community 
    if (isset($communityID)){
        //get the posts for this community
        $sqlPosts = "SELECT postID, title, content, like_count from posts where communityID= $communityID";
        
        //get info about the community to display
        $communityInfo = "SELECT communityName, communityRules, communityDescription, tags from communities where communityID=$communityID";

        //results
        $resultPosts = $conn->query($sqlPosts);
        $resultComm = $conn->query($communityInfo);

        //display the name of the community, rules, etc.
        if ($resultComm->num_rows > 0) {
            while ($rowComm = $resultComm->fetch_assoc()) {
                echo '<div class="container"><h1>' . $rowComm['communityName'] . '</h1><h4> Description: ' . $rowComm['communityDescription'] . '</h4><p>Rules: ' . $rowComm['communityRules'] . '</p><p> Tags: ' . $rowComm['tags'] . '</p>';
            }
        }

        //loop through posts and put them on cards
        if ($resultPosts->num_rows > 0) {
            while ($rowPost = $resultPosts->fetch_assoc()) {
                echo '<div><div class="card-body">
                <h5 class="card-title">' . $rowPost['title'] . '</h5>
                <p class="card-text">' . $rowPost['content'] . '</p>
                <a href="user_communities.php?postID=' . $rowPost['postID'] .  '&communityID=' . $communityID . '" class="card-link">Comment</a>
                <a href="user_communities.php?postID=' . $rowPost['postID'] . '&communityID=' . $communityID . '" class="card-link"><i class="fa-regular fa-thumbs-up"></i>' . $rowPost['like_count'] . '</a>
              </div>';
            }
        } 
        else {
            echo "No posts available in your community.";
        }
    }

    //UPDATE LIKE COUNT
    elseif (isset($_GET["postID"]) && isset($_GET["communityID"])) {
        
        $postID = $_GET["postID"];
        $communityID = $_GET['communityID'];

        //update the like count
        $updateLikeCount = "UPDATE posts SET like_count = like_count + 1 WHERE postID = $postID";

        $resultLike = $conn->query($updateLikeCount);

        header('Location: user_communities.php?community_id=' . $communityID);
        exit();
    }
    //User hasn't chosen a community to view, still browsing THEIR COMMUNITIES
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
                    <h2>' . $rowComm['communityName'] . '</h2>
                    <div>
                        <p>' . $rowComm['communityDescription'] . '</p>
                        <a href="user_communities.php?community_id=' .  $rowComm['communityID'] . '" class="btn btn-success">Go to community</a>
                    </div>
                    </div>';
                }
                echo '</div>';
                echo '</div>';
            }
            //user isn't in any communities
            else{
                echo "<div class=container mx-auto p-2><h4>You haven't joined any communities yet!</h4><a href='join-community.php'><p>Click here</a> to browse our communities.</p></div>";
            }
    }
    else{
        echo "oops";
    }
        $conn->close();
?>

<?php include('./includes/boot-script.php')?>

</body>
</html>