<!-- Start Session -->
<?php session_start(); 
$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        include('./includes/boot-head.php');
        include('./includes/google-fonts.php');
    ?>

    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <title>Join A Community</title>

    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
<?php 
include('./includes/nav.php'); ?>

<!-- Add user & communityID to db, redirect to community page they join -->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["community_id"])) {
        if (isset($_GET["community_id"])) {
            $community_id = $_GET["community_id"];
        
        // Database connection
        $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $joinCommunity = "INSERT INTO user_community (userID, communityID) VALUES ('$userID', '$community_id')";
        
        $conn->query($joinCommunity);
        //set flag that user has joined successfully
        $_SESSION['join_community'] = true;
        //redirect to that community page, pass the community ID 
        header('Location: user_communities.php?community_id=' . $community_id);
        exit();

        $conn->close();
    }
}
?>


<div class="container px-4 mx-auto p-2">
  <h1 class="com">Communities</h1>
  <h2 class="com">Join one of our many communities to help make a difference in preventing fast fashion.</p>


<!-- DISPLAY COMMUNITIES -->
<?php
    //set user ID to locate communities they are not in
    $userID = $_SESSION['userID'];
    // Database connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch and display communities user is not a part of
    $sql = "SELECT c.communityID, c.communityName, c.communityDescription, c.communityRules, c.tags
    FROM communities c
    LEFT JOIN user_community uc ON c.communityID = uc.communityID AND uc.userID = $userID
    WHERE uc.userID IS NULL";
    $result = $conn->query($sql);

    echo "<div class='community-box mx-auto p-5'>";
    // echo "<div class='grid-container'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="grid-item mb-3">';
            echo '<h3 class="com">' . htmlspecialchars($row["communityName"]) . '</h3>';
            echo '<p class="com"><strong>Description:</strong> ' . nl2br(htmlspecialchars($row["communityDescription"])) . '</p>';
            echo '<p class="com"><strong>Rules: </strong>' . nl2br(htmlspecialchars($row["communityRules"])) . '</p>';
            echo '<p class="com"><strong>Tags: </strong>' . htmlspecialchars($row["tags"]) . '</p>';
            echo '<a class="button mt-2" href="join-community.php?community_id=' . $row["communityID"] . '">Join &raquo;</a>';
            echo '</div>';

            //close db
            $conn->close();
        }
    } else {
        echo "You have joined all of our communities!";
    }

    // echo "</div>";

    ?>
</div>

<!-- Footer --> 
<?php 
include('./includes/footer.php');
include('./includes/boot-script.php');
?>

</body>
</html>
        