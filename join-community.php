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

<<<<<<< HEAD
=======

>>>>>>> ed0546e862b500dd2bc2b8eb87ed7fa7d1d8912d
    <div class="container mt-4">
        <h4>Communities</h4>
        <?php
        $conn = mysqli_connect("db.luddy.indiana.edu");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
<<<<<<< HEAD
        }
    
=======
        }
>>>>>>> ed0546e862b500dd2bc2b8eb87ed7fa7d1d8912d
