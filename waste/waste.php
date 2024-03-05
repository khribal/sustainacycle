<?php session_start(); 
  //db connection
  $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //get userID of recycler making request
  $recUserID = $_SESSION['userID'];

  //find the recycler's id
  $findRecID = "SELECT r.companyID from recyclers as r join users as u on u.userID=r.userID WHERE u.userID=$recUserID";
  $recIDResult = $conn->query($findRecID);
  if ($recIDResult) {
    // Fetch the array
    $resultRow = $recIDResult->fetch_assoc();
    // Access the value
    $recyclerID = $resultRow['companyID'];
  }
  
//recycler clicked request btn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestBtn'])) {

  //get manufacturer and material ID
  $materialID = $_POST['materialID'];
  $quantity = $_POST['quantity'];

  //insert the request into the table
  $insertRequest="INSERT INTO requests (materialID, recyclerID, quantity, reqStatus) VALUES ($materialID, $recyclerID, $quantity, 'Pending')";
  $conn->query($insertRequest);

  // set success flag for user
  $_SESSION['request-success'] = true;
  //redirect so the page reloads
  header('Location: waste.php');
  exit();
}

//close db
$conn->close();
?>
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

<?php include('../includes/waste-nav.php');
if (isset($_SESSION['request-success']) && $_SESSION['request-success']) {
  echo '<div style="text-align: center; color: green; font-size: 20px; font-weight: bold;">Request Successful.</div>';
  // Reset the flag to avoid showing the message on subsequent visits
  $_SESSION['registration_success'] = false;
}
?>

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

            //GET EACH MANUFACTURER QUANTITY which doesn't have a request
            $manufactWithMaterial = "SELECT 
            m.quantity,
            ma.companyName,
            m.description,
            ma.manufacturerID,
            m.materialID
        FROM
            materials AS m
        JOIN
            users AS u ON u.userID = m.userID
        JOIN
            manufacturers AS ma ON ma.userID = u.userID
        WHERE
            m.materialName = '$materialName'
            AND NOT EXISTS (
                SELECT 1
                FROM requests AS r
                WHERE r.materialID = m.materialID
            )
        GROUP BY
            ma.companyName, m.materialName";

            $manuResult = $conn->query($manufactWithMaterial);
            
            //start the container for this material's grid
            echo "<div class='grid-container'>";
            while ($row_manufacturer = mysqli_fetch_assoc($manuResult)) {
              
              //store the name and quantity
              $companyName = $row_manufacturer['companyName'];
              $totalQuantity = $row_manufacturer['quantity'];
              $manuID = $row_manufacturer['manufacturerID'];
              $matID = $row_manufacturer['materialID'];

              //echo grid item
              echo "<div class='grid-item'>";
              echo "<p class='waste'><strong>Manufacturer: </strong>" . $companyName . "</p>";
              echo "<p class='waste'><strong>Quantity: </strong>" . $totalQuantity . " lbs</p>";
              echo '<div class="row"><div class="col-sm">';
              echo '<form method="post" action="waste.php"><input type="hidden" name="materialID" value="' . $matID . '"><input type="hidden" name="quantity" value="' . $totalQuantity . '">';
              echo '<button type="submit" class="btn btn-success" name="requestBtn">Request waste</button></form>';
              echo '</div></div>';
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
    include('../includes/waste-footer.php');
    include('../includes/boot-script.php');
?>

</body>
</html>