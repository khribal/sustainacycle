<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>See Available Waste</title>
</head>
<body>
<?php include('includes/nav.php'); ?>


  <h2>Add Waste</h2>
  <form action="process-waste.php" method="POST">
    <label for="manufacturerID">Manufacturer ID:</label><br>
    <input type="text" id="manufacturerID" name="manufacturerID"><br><br>

    <label for="materialName">Material Name:</label><br>
    <select id="materialName" name="materialName">
      <?php
        $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT DISTINCT materialName FROM materials";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<option value=\"" . $row["materialName"] . "\">" . $row["materialName"] . "</option>";
          }
        }
        $conn->close();

        ?>
    </select><br><br>

    <label for="quantity">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity"><br><br>

    <input type="submit" value="Submit">
  </form>
  <!-- Footer --> 
<footer class="container mx-auto p-2">
<p>&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
</footer>

</body>
</html>