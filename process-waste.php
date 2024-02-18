<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manufacturerID = $_POST["manufacturerID"];
    $materialName = $_POST["materialName"];
    $quantity = $_POST["quantity"];

    if (empty($manufacturerID) || empty($materialName) || empty($quantity)) {
        echo "All fields must be filled.";
    } else {
        $conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
    }
}

?>