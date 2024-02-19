<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>See Available Waste</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>

<?php include('includes/nav.php') ?>

<div class="container px-4 mx-auto p-2">
  <h1 class="video">Available Waste</h1>
  <p class="video">See what materials manufacturers have available to be recycled right now!</p>
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
      echo "<div class='container mx-auto p-2'>";
      $currentManufacturer = null;
        while($row = $result->fetch_assoc()) {
          if ($row["companyName"] !== $currentManufacturer) {

            if ($currentManufacturer !== null) {
              echo "</div>";
            }

            echo "<h2 class='mt-4 waste'>" . $row["companyName"] . "</h2>";
            echo "<div class='grid-container'>";
            $currentManufacturer = $row["companyName"];
          }
          
          echo "<div class='grid-item'>";
          echo "<p class='waste'><strong>Material Name: </strong>" . $row["materialName"]. "</p>";
          echo "<p class='waste'><strong>Quantity: </strong>" . $row["quantity"]. "</p>";
          echo "<p class='waste'><strong>Description: </strong>" . $row["description"]. "</p>";
          echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>

    <!-- Footer --> 
    <footer class="container mx-auto p-2">
    <p>&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
    </footer>

</body>
</html>