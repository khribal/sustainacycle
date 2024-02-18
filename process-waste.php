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

        $sql = "INSERT INTO materials (manufacturerID, materialName, quantity) VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $manufacturerID, $materialName, $quantity);

        if ($stmt->execute()) {
            echo "Waste added successfully.";
        } else {
            echo "Error: " . $sql . "<br> . $conn->error;"
        }

        $stmt->close();
        $conn->close();
    }
} else {
    header("Location: add-waste.php");
    exit();
}
?>