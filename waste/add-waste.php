<?php 
ob_start(); // Start output buffering
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php include('../includes/boot-head.php'); 
    include('../includes/google-fonts.php');?>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <title>Add Waste</title>
</head>
<body>
<?php 
include('../includes/waste-nav.php'); 
?>

<div class="container px-4 mx-auto p-2">
  <h1 class="video">Add Waste</h1>
  <p class="video">Enter the information below to add available waste to our site.</p>


  <form id="wasteForm" action="add-waste.php" method="POST">
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
    <input type="text" id="quantity" name="quantity"><br><br>

    <input type="submit" value="Submit">
  </form>
</div>

<!-- Footer, bootstrap --> 
<?php 
    include('../includes/boot-script.php'); 
    include('../includes/waste-footer.php');
?>


<!-- PROCESS FORM FOR ADDING WASTE -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materialName = $_POST["materialName"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    if (empty($materialName) || empty($quantity) || empty($description)) {
        echo "All fields must be filled.";
    } else {
        // Grab the user ID from the session
        $userID = $_SESSION['userID'];

        $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use the user ID to find the manufacturer ID
        $manuIDQuery = "SELECT * FROM manufacturers WHERE userID='$userID'";
        $manuIDResult = mysqli_query($conn, $manuIDQuery);
        
        if ($manuIDResult) {
            $row = mysqli_fetch_assoc($manuIDResult);

            $manufacturerID = $row['manufacturerID']; 
  
            $checkMaterials = "SELECT materialName from materials where manufacturerID=$manufacturerID";
            $checkMatResult = $conn->query($checkMaterials);

            //check if manufacturer already has that material in database
            if ($checkMatResult) {
              while ($row = $checkMatResult->fetch_assoc()) {
                  // Access the materialName column in the current row
                  $existingMaterialName = $row['materialName'];
                  // Compare with the materialName you want to check
                  if ($materialName == $existingMaterialName) {
                      // Material name already exists, update that record
                      $updateMat = "UPDATE materials SET quantity=$quantity, description='$description'
                      where manufacturerID=$manufacturerID AND materialName='$materialName'";

                      $conn->query($updateMat);
                  }
              }
          }else{
            //create new record for that material
            $sql = "INSERT INTO materials (manufacturerID, materialName, quantity, description) VALUES ($manufacturerID, '$materialName', $quantity, '$description')";
            
            // Insert form results into the database
            $result = $conn->query($sql);
            
          }
            mysqli_close($conn); // Close the database connection

            if ($result) {
                $_SESSION['add_success'] = true; // Set a success flag
                header("Location: ./manu_waste.php");
                exit();
            }
        } else {
            echo "Error: " . $manuIDQuery . "<br>" . $conn->error;
        }
    }
}
?>

<?php ob_end_flush(); // Flush the output buffer and send it to the browser ?>

</body>
</html>