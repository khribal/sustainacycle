<?php 
// Connect to the database
$conn = mysqli_connect("db.luddy.indiana.edu", "i494f23_team20", "my+sql=i494f23_team20", "i494f23_team20");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve existing passwords
$sql = "SELECT userID, pass FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Hash the password
        $hashedPassword = password_hash($row['pass'], PASSWORD_BCRYPT);

        echo "User ID: " . $row['userID'] . ", Hashed Password: " . $hashedPassword . "<br>";

        // Update the database with the hashed password
        $updateSql = "UPDATE users SET pass = '$hashedPassword' WHERE userID = " . $row['userID'];
        $conn->query($updateSql);
    }
}

$conn->close();

echo "Password hashing complete.";

?>