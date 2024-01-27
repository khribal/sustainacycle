<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>See Available Waste</title>
</head>
<body>

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

<div class="jumbotron">
  <div class="container">
    <h4>See what materials manufacturers have available to be recycled right now!</h4>
  </div>
</div>

<?php
    $conn = mysqli_connect("db.luddy.indiana.edu", "i495s24_team20", "my+sql=i495s24_team20", "i495s24_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT materialName, quantity, manufacturerID FROM materials";
    $result = $cpmm->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Material Name: " . $row["materialName"]. "<br>Quantity: " . $row["quanity"]. "<br>Manufacturer: " . $row["ManufacturerID"];
        }
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>


</body>
</html>