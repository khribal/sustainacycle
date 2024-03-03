<?php 
session_start();

//connect to the database
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

//user clicked edit or delete
//USER CLICKED EDIT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteBtn'])){
    //get the materialID so we know what to delete
    $materialID = $_POST['materialID'];
    $userID = $_SESSION['userID'];

    $delMaterial = "DELETE FROM materials WHERE materialID=$materialID";

    if($conn->query($delMaterial)){
        // Check the affected rows
    if ($conn->affected_rows > 0) {
        // Material deleted successfully
        // Refresh the page for the user so the changes load
        header("Location: manu_waste.php");
        exit();
    } else {
        // No rows were affected (perhaps the material with given ID doesn't exist)
        echo "Material not found or not deleted.";
    }
    }
}//user clicked EDIT
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveBtn'])){
    
    $editedMaterialID = $_POST['materialID'];
    $editedMaterialName = $_POST['editmaterialName'];
    $editedQuantity = $_POST['editquantity'];
    $editedDescription = $_POST['editdescription'];

    
        // Update the database with edited values
        $updateMaterial = "UPDATE materials SET 
        materialName='$editedMaterialName', 
        quantity=$editedQuantity, 
        description='$editedDescription' 
        WHERE materialID='$editedMaterialID'";

        
        // Check the affected rows
        if ($conn->query($updateMaterial) === TRUE) {
            echo "Error: " . $conn->error;
            // Material updated successfully
            // Redirect to the same page to reflect the changes
            header("Location: manu_waste.php");
            exit();
        }
     else {
    // Error in the SQL query
    echo "Error updating material: " . $conn->error;
    }
}

//close conn
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Waste</title>
    <!-- Bootstrap, google fonts -->
    <?php include('../includes/boot-head.php'); 
    include('../includes/google-fonts.php'); ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<?php include('../includes/waste-nav.php'); 
//success message if waste added
if (isset($_SESSION['add_success']) && $_SESSION['add_success']){
    echo '<div style="text-align: center; color: green; font-size: 16px; font-weight: bold;"> Material successfully added!</div>';
    $_SESSION['add_success'] = false;
  }
?>

<div class="container px-4 mx-auto p-2">
  <h1 class="video">Your Waste</h1>
  <p class="video">View, edit, and delete your posted waste.</p>
  <div class="grid-container">
    <?php 
    //display the manufacturers posted materials (waste) on this page, so they can edit/remove if they want.
    $manufacturerUserID=$_SESSION['userID'];

    //connect to the database
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    //grab the manufacturerID
    $idQuery="SELECT manufacturerID FROM manufacturers where userID=$manufacturerUserID";
    //get result 
    $idResult= $conn->query($idQuery);
    //store result
    $row = $idResult->fetch_assoc();

    // Check if a row was fetched
    if ($row) {
        // Access the manuID
        $manuID = $row['manufacturerID'];
    }

    //grab materials
    $yourMaterials = "SELECT materialName, quantity, description, materialID from materials where manufacturerID=$manuID";

    $mResult = $conn->query($yourMaterials);

    while ($row = $mResult->fetch_assoc()){
        //get material id for edit/delete functionality
        $materialID = $row['materialID'];
        //edit mode to show save button if necessary
        $isEditMode = isset($_POST['editBtn']) && $_POST['materialID'] == $materialID;

         // Display grid item in read-only or editable mode
         echo '<div class="grid-item" data-material-id=' . $materialID . '>
         <form method="post" action="manu_waste.php">
         <h5 class="card-title">' . ($isEditMode ? '<input type="text" name="editmaterialName" value="' . $row['materialName'] . '">' : $row['materialName']) . '</h5>
         <h6 class="card-subtitle mb-2 text-muted">' . ($isEditMode ? 'Quantity: <input type="text" name="editquantity" value="' . $row['quantity'] . '">' : 'Quantity: ' . $row['quantity']) . '</h6>
         <p class="card-text">' . ($isEditMode ? '<textarea name="editdescription">' . $row['description'] . '</textarea>' : $row['description']) . '</p>
         <div class="row">
             <div class="col-sm">
                     <input type="hidden" name="materialID" value="' . $materialID . '">
                     ' . ($isEditMode ? '<button type="submit" class="btn btn-success" name="saveBtn">Save</button>' : '<button type="submit" class="btn btn-success" name="editBtn">Edit</button>') . '
                     <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                 </form>
             </div>
         </div>
     </div>';
 }


    //close conn
    $conn->close();

    ?>
</div>
</div>

<?php 
include('../footer.php');
include('../includes/boot-script.php'); 
?>
</body>
</html>