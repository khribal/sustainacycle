<?php
// process-google.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_token = $_POST['id_token'];
    $name = $_POST['name'];
    $email = $_POST['email'];


    // Example: Return a JSON response
    echo json_encode(['success' => true]);
} else {
    // Handle the case where the POST data is not set
    echo json_encode(['error' => 'POST data not received.']);
}
?>
