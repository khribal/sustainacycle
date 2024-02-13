<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--  library jwt-decode to handle JWT decoding -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jwt-decode/3.1.2/jwt-decode.min.js"></script>

</head>
<body>
    <?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the POST data is set
if (isset($_POST['id_token'])) {
    // Get the ID token from the POST data
    $id_token = $_POST['id_token'];

    // Decode the ID token to get user information using json_decode
    $decoded_token = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $id_token)[1])), true);

    // Extract the desired user information
    $user_name = $decoded_token['name'];
    $user_email = $decoded_token['email'];

    // Now you can use $user_name and $user_email as needed
    // For example, you can store them in a database or echo them
    echo "User Name: " . $user_name . "<br>";
    echo "User Email: " . $user_email;
} else {
    // Handle the case where the POST data is not set
    echo "Error: POST data not received.";
}

?>


</body>
</html>