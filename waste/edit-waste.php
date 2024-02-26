<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Waste</title>
    <?php include('./includes/boot-head.php'); ?>
</head>
<body>
<?php include('./includes/nav.php'); ?>

<?php

if(isset($_GET['id'])) {
    $materialID = $_GET['id'];

    //connect to the database
    $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM materials WHERE materialID = $materialID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $material = $result->fetch_assoc();
    } else {
        echo "Material not found.";
        exit;
    }
} else {
    echo "Material ID not provided.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $updatedMaterialName = $_POST["materialName"];
    $updatedQantity = $_POST["quantity"];
    $updatedDescription = $_POST["description"];

    $updateQuery = "UPDATE materials SET materialName = '$updatedMaterialName', quantity = $updatedQuantity, description = '$updatedDescription' WHERE materialID = $materialID";
    if ($conn->query($updateQuery) === TRUE) {
        echo "Material updated successfully.";
    } else {
        echo "Eror updating material: " . $conn->error;
    }

    $conn->close();
}

?>

<div class="container">
    <h2>Edit Material</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="materialName">Material Name:</label>
            <input type="text" class="form-control" id="materialName" name="materialName" value="<?php echo $material['materialName']; ?>">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $material['quantity']; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?php echo $material['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Material</button>
    </form>
</div>

<?php 
include('./footer.php');
include('./includes/boot-script.php'); 
?>
</body>
</html>