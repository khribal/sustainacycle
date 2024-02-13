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

    // Echo the ID token to check if data is received
    echo "Received ID Token: " . $id_token;
} else {
    // Handle the case where the POST data is not set
    echo "Error: POST data not received.";
}

?>


</body>
</html>