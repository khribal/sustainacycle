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
// Check if the POST data is set
    if (isset($_POST['id_token'])) {
    // Get the ID token from the POST data
        $id_token = $_POST['id_token'];

    // Decode the ID token to get user information using json_decode
    $decoded_token = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $id_token)[1])), true);
    
    //Extract information about the user
    $full_name = $decoded_token['name'];

    // Split the full name first and last names
    $name_parts = explode(" ", $full_name);

    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
    
    $user_email = $decoded_token['email'];
    
    
} else {
    // Handle the case where the POST data is not set
    echo "Error: POST data not received.";
}

?>


</body>
</html>