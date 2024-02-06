<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Join Community</title>
</head>

<body>
<!-- nav bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="team.php">About Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="project.php">About the Project</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="video.php">Promotional Video</a>
        </li>
        </ul>
    </div>
    </nav>


    <div class="container mt-4">
        <h4>Communities</h4>
        <?php
        $conn = mysqli_connect("db.luddy.indiana.edu");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    
    // display available communities//
        $sqlcommunities = "SELECT id, name FROM communities";
        $resultcommunities = $conn->query($sqlcommunities);

        if ($resultcommunities->num_rows > 0) {
            echo "<ul>";
            while ($rowcommunity = $resultcommunities->fetch_assoc()) {
                echo "<li>{$rowcommunity['name']} - <a href='join-community.php?community_id={$rowcommunity['id']}'>Join</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No communities available.";
        }
        ?>

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
        