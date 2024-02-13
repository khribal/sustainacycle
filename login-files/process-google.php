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
if (isset($_POST['id_token'])) {
    // Get the ID token from the POST data
    $id_token = $_POST['id_token'];

    // Decode the ID token to get user information
    $decoded_token = jwt_decode($id_token);

    // Extract the desired user information
    $user_name = $decoded_token->name;
    $user_email = $decoded_token->email;

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