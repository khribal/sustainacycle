<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Waste</title>
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

    $deleteQuery = "DELETE FROM materials WHERE materialID = $materialID";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Waste deleted successfully.";
    } else {
        echo "Error deleting waste: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Material ID not provided.";
    exit;
} 
?>

<div class="container">
    <p><a href="waste.php">Go back to waste management</a></p>
</div>
<?php 
include('./footer.php');
include('./includes/boot-script.php'); 
?>
</body>
</html>