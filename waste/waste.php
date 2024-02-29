<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap, google fonts -->
    <?php 
      include('../includes/boot-head.php');
      include('../includes/google-fonts.php');
    ?>
    <!-- CSS-->
    <link rel="stylesheet" href="../css/styles.css">
    <title>See Available Waste</title>
</head>
<body>

<?php include('../includes/nav.php') ?>

<div class="container px-4 mx-auto p-2">
  <h1 class="video">Available Waste</h1>
  <p class="video">See what materials manufacturers have available to be recycled right now!</p>
</div>


<!-- grid of materials -->
<?php
    //db connection
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    //GET LIST OF each material 
    $sqlMaterials = "SELECT distinct materialName, description from materials";

    $materialResult = $conn->query($sqlMaterials);

    if ($materialResult->num_rows > 0) {
      echo "<div class='container mx-auto p-2'>";
        while($row = $materialResult->fetch_assoc()) {
          //store the material name to use in next query
          $materialName = $row['materialName'];
          $description = $row['description'];

            echo "<h2 class='mt-4 waste'>" . $materialName . "</h2>";
            echo "<p>" . $description . "</p>";

            //GET EACH MANUFACTURER QUANTITY
            $manufactWithMaterial="SELECT sum(m.quantity) as quantity, ma.companyName, m.description
            FROM materials as m
            JOIN manufacturers as ma ON m.manufacturerID=ma.manufacturerID
            where m.materialName='$materialName'
            group by ma.companyName, m.materialName";

            $manuResult = $conn->query($manufactWithMaterial);
            
            //start the container for this material's grid
            echo "<div class='grid-container'>";
            while ($row_manufacturer = mysqli_fetch_assoc($manuResult)) {
              
              //store the name and quantity
              $companyName = $row_manufacturer['companyName'];
              $totalQuantity = $row_manufacturer['quantity'];
              
              //echo grid item
              echo "<div class='grid-item'>";
              echo "<p class='waste'><strong>Manufacturer:</strong>" . $companyName . "</p>";
              echo "<p class='waste'><strong>Quantity: </strong>" . $totalQuantity . " lbs</p>";
              if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'recycler'){
                echo '<button type="button" class="btn btn-success">Request waste</button>';
              }
              echo "</div>";
            }
            echo "</div>";
          }
          echo "</div>";
        }
        
        
      // else {
      //   echo "0 results";
      // }
    $conn->close();
    ?>

  

<!-- Bootstrap, footer -->
<?php 
include('../includes/footer.php');
include('../includes/boot-script.php');
?>

</body>
</html>