<?php 
//UPDATE LIKE COUNT
if (isset($_GET["postID"])) {
    $postID = $_GET["postID"];
    //select the like count
    $updateLikeCount = "UPDATE posts SET like_count = like_count + 1 WHERE postID = $postID";

    $resultLike = $conn->query($updateLikeCount);
}
?>