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

<?php include('includes/nav.php') ?>

<div class="jumbotron">
  <div class="container">
    <h4>See what materials manufacturers have available to be recycled right now!</h4>
  </div>
</div>

<?php
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT materials.manufacturerID, materials.materialName, materials.quantity, materials.description, manufacturers.companyName
    FROM materials
    JOIN manufacturers ON materials.manufacturerID = manufacturers.manufacturerID
    ORDER BY manufacturers.companyName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<div class='container'>";
      $currentManufacturer = null;
        while($row = $result->fetch_assoc()) {
          if ($row["companyName"] !== $currentManufacturer) {

            if ($currentManufacturer !== null) {
              echo "</div>";
            }

            echo "<h2 class='mt-4'>" . $row["companyName"] . "</h2>";
            echo "<div class='grid-container'>";
            $currentManufacturer = $row["companyName"];
          }
          
          echo "<div class='grid-item'>";
          echo "<p><strong>Material Name: </strong>" . $row["materialName"]. "</p>";
          echo "<p><strong>Quantity: </strong>" . $row["quantity"]. "</p>";
          echo "<p><strong>Description: </strong>" . $row["description"]. "</p>";
          echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>


</body>
</html>