<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Add Waste</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<?php include('includes/nav.php'); ?>

<div class="container px-4 mx-auto p-2">
  <h1 class="video">Add Waste</h1>
  <p class="video">Enter the information below to add available waste to our site.</p>


  <form id="wasteForm" action="process-waste.php" method="POST">
    <label for="manufacturerID" class="add">Manufacturer ID:</label><br>
    <input type="text" id="manufacturerID" name="manufacturerID"><br><br>

    <label for="materialName" class="add">Material Name:</label><br>
    <select id="materialName" name="materialName">  
      <option value="" class="add">Select Material</option>
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

    <label for="quantity" class="add">Quantity:</label><br>
    <input type="number" id="quantity" name="quantity"><br><br>

    <label for="description" class="add">Description:</label><br>
    <textarea id="description" name="description" rows="4" cols="50" readonly></textarea><br>

    <input type="submit" value="Submit">
  </form>
</div>

  <!-- Footer --> 
<footer class="container mx-auto p-2">
<p>&copy;IU INFO-I495 F23 Team 20, 2023-2024</p>
</footer>


  <script>
    document.getElementById('materialName').addEventListener('change', function() {
      var materialName = this.value;
      var descriptionField = document.getElementById('description');

      if (materialName === 'Cotton') {
        descriptionField.value = 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.';
      } else if (materialName === 'Silk') {
        descriptionField.value = 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.';
      } else if (materialName === 'Polyester') {
        descriptionField.value = 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.';
      } else if (materialName === 'Linen') {
        descriptionField.value = 'Natural, breathable fabric, crisp and lightweight. Ideal for comfortable, casual elegance in clothing and home textiles.';
      } else if (materialName === 'Wool') {
        descriptionField.value = 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.';
      } else if (materialName === 'Leather') {
        descriptionField.value = 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.';
      } else if (materialName === 'Satin') {
        descriptionField.value = 'Smooth, glossy fabric. Lustrous, luxurious sheen. Often used for elegant, high-quality garments and accessories.';
      }
    });
  </script>
</body>
</html>