<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Join A Community</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
<?php include('includes/nav.php'); ?>

<div class="container px-4 mx-auto p-2">
  <h1 class="com">Communities</h1>
  <h2 class="com">Join one of our many communities to help make a difference in preventing fast fashion.</p>


    <?php
    // Database connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch and display communities
    $sql = "SELECT communityID, communityName, Description, communityRules, tags FROM communities";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='community-box mx-auto p-5'>";
            echo "<h3 class='com'>" . htmlspecialchars($row["communityName"]) . "</h3>";
            echo "<p class='com'><strong>Description:</strong> " . nl2br(htmlspecialchars($row["Description"])) . "</p>";
            echo "<p class='com'><strong>Rules:</strong> " . nl2br(htmlspecialchars($row["communityRules"])) . "</p>";
            echo "<p class='com'><strong>Tags:</strong> " . htmlspecialchars($row["tags"]) . "</p>";
            echo "<a href='join-community.php?community_id=" . $row["communityID"] . "' class='button mt-2'>Join &raquo;</a>";
            echo "</div>";
        }
    } else {
        echo "No communities available.";
    }

    $conn->close();
    ?>
</div>
    <!-- posts -->
        <?php
        $sqlPosts = "SELECT posts.*, communites.name AS community_name
                    FROM posts
                    JOIN communities on posts.community_id = communities.id
                    WHERE posts.comunity_id IN (
                        SELECT community_id FROM user_communities WHERE user_id = '$user_id'
                    )";

        $resultPosts = $conn->qury($sqlPosts);

        if ($resultPosts->num_rows > 0) {
            while ($rowPost = $resultPosts->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p>{$rowPost['community_name']} - {$rowPost['content']}</p>";
                echo "</div>";
            }
        } else {
            echo "No posts available in your communities.";
        }

        $conn->close();
        ?>

    </div>
    

    
    <!-- allow user to join community -->

    <?php
    session_start();
    require_once "config.php";

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION["user_id"];

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["community_id"])) {
        $community_id = $_GET["community_id"];

        // checking if user joined community /
        $checkMembership = "SELECT id FROM user_communitiess WHERE user_id = '$user_id' AND community_id = '$community_id'";
        $result = $conn->query($checkMembership);
        // if not joined then join//
        if ($result->num_rows == 0) {
            $joinCommunity = "INSER INTO user_communities (user_id, community_id) VALUES ('$user_id', '$community_id')";
            $conn->query($joinCommunity);
            echo "You have joined the community!";
        } else {
            echo "You are already a member of this community.";
        }
    }

    $conn->close();
    ?>
</div>
<!-- Footer --> 
<footer class="container mx-auto p-2">
<p>&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
</footer>
</body>
</html>
        