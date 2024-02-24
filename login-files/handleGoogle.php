<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include jwt-decode -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/dist/jwt-decode.min.js"></script> -->
</head>
<body>


<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Get $id_token via HTTPS POST.
// if ($_SERVER['REQUEST_METHOD'] == "POST") {
//     $id_token = $_POST['credential'];
//     echo "Token: " . $id_token . "<br>";
// }
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_token = $_POST['credential'];
    echo "Token: " . $id_token . "<br>";

    $client = new Google_Client(['client_id' => '605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($id_token);

    if ($payload) {
        $userid = $payload['sub'];
        echo "User ID: " . $userid . "<br>";
        // Additional processing if needed
    } else {
        echo 'Invalid ID token';
    }
}


?>


</body>
</html>
