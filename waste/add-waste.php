<?php 
ob_start(); // Start output buffering
session_start(); 
$userID = $_SESSION['userID'];
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
    <input type="text" id="description" name="description"><br><br>

    <input type="submit" name="submitMat" value="Submit">
  </form>
</div>

<!-- Footer, bootstrap --> 
<?php 
    include('../includes/boot-script.php'); 
    include('../includes/waste-footer.php');
?>


<!-- PROCESS FORM FOR ADDING WASTE -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitMat'])) {
    $materialName = $_POST["materialName"];
    $quantity = $_POST["quantity"];
    $description = $_POST["description"];

    if (empty($materialName) || empty($quantity) || empty($description)) {
        echo "All fields must be filled.";
    } else {
        $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //Check if this manufacturer already has this material
        $checkMaterials = "SELECT materialName, quantity from materials where userID=$userID";
        $checkMatResult = $conn->query($checkMaterials);

            
        if ($checkMatResult) {
          while ($row = $checkMatResult->fetch_assoc()) {
              // Access the materialName column in the current row
              $existingMaterialName = $row['materialName'];
              $existingQuantity = $row['quantity'];

              // Compare with the materialName you want to check
              if ($materialName == $existingMaterialName) {
                  // Material name already exists, update that quantity
                  $totalQuantity = $existingQuantity + $quantity;
                  //update record
                  $updateMat = "UPDATE materials SET quantity=$totalQuantity, description='$description'
                  where userID=$userID AND materialName='$materialName'";

                  $conn->query($updateMat);
              }
              //User doesn't have this specific material, add new record
              else{
              //create new record for that material
              $sql = "INSERT INTO materials (userID, materialName, quantity, description) VALUES ($userID, '$materialName', $quantity, '$description')";
              // Insert form results into the database
              $result = $conn->query($sql);
              if ($result) {
                $_SESSION['add_success'] = true; // Set a success flag
                header("Location: ./manu_waste.php");
                exit();
              }
              }
              }
            }
            //user doesn't have ANY material in database yet, make new record
            else{
              //create new record for that material
              $sql = "INSERT INTO materials (userID, materialName, quantity, description) VALUES ($userID, '$materialName', $quantity, '$description')";
              // Insert form results into the database
              $result = $conn->query($sql);
              if ($result) {
                $_SESSION['add_success'] = true; // Set a success flag
                header("Location: ./manu_waste.php");
                exit();
              }
            }

            mysqli_close($conn); // Close the database connection
    }
}
?>

<?php ob_end_flush(); // Flush the output buffer and send it to the browser ?>

</body>
</html>