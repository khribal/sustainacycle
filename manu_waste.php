<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Waste</title>
    <?php include('./includes/boot-head.php'); ?>
</head>
<body>
<?php include('./includes/nav.php'); ?>

<div class="container">
    <?php 
    //display the manufacturers posted materials (waste) on this page, so they can edit/remove if they want.
    session_start();
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
    $yourMaterials = "SELECT materialName, quantity, description from materials where manufacturerID=$manuID";

    $mResult = $conn->query($yourMaterials);

    while ($row = $mResult->fetch_assoc()){
        echo '<div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">' . $row['materialName'] . '</h5>
            <h6 class="card-subtitle mb-2 text-muted"> Quanity: ' . $row['quantity'] . '</h6>
            <p class="card-text">'. $row['description'] . '</p>
        </div>
        </div>';
    }
    //close conn
    $conn->close();

    ?>
</div>

<?php 
include('./footer.php');
include('./includes/boot-script.php'); 
?>
</body>
</html>