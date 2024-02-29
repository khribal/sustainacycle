<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('./includes/boot-head.php')?>

    <link rel="stylesheet" href=".css/styles.css">
    <title>Join A Community</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
<?php 
include('./includes/nav.php'); ?>

<!-- Add user & communityID to db, redirect to community page they join -->
<?php
    // if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["community_id"])) {
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

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='community-box mx-auto p-5'>";
            echo "<h3 class='com'>" . htmlspecialchars($row["communityName"]) . "</h3>";
            echo "<p class='com'><strong>Description:</strong> " . nl2br(htmlspecialchars($row["communityDescription"])) . "</p>";
            echo "<p class='com'><strong>Rules:</strong> " . nl2br(htmlspecialchars($row["communityRules"])) . "</p>";
            echo "<p class='com'><strong>Tags:</strong> " . htmlspecialchars($row["tags"]) . "</p>";
            echo "<a href='join-community.php?community_id=" . $row["communityID"] . "' class='button mt-2'>Join &raquo;</a>";
            echo "</div>";
        }
    } else {
        echo "You have joined all of our communities!";
    }

    $conn->close();
    ?>
</div>

<!-- Footer --> 
<?php 
include('./includes/footer.php');
include('./includes/boot-script.php');
?>

</body>
</html>
        