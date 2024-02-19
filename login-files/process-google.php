<?php
// Allow OPTIONS request to handle preflight CORS checks
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    exit;
}

// Handle Google login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data    
    $data = file_get_contents("php://input");
    
    // Decode the JSON data
    $postData = json_decode($data);

    // Check if 'id_token' is present in the decoded data
    if (isset($postData->id_token)) {
        $id_token = $postData->id_token;

        // Decode the ID token to get user information
        $decoded_token = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], explode('.', $id_token)[1])), true);
        
        // Extract information from the decoded JSON data
        $user_email = $decoded_token['email'];

        // Respond with a simple success message
        $response = array("success" => true, "message" => "Received data successfully");
        echo json_encode($response);
    } else {
        // Handle the case where 'id_token' is not present
        $response = array("success" => false, "error" => "Invalid POST data");
        echo json_encode($response);
    }
} else {
    // Handle other request methods (GET, etc.) if needed
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    $response = array("success" => false, "error" => "Invalid request method");
    echo json_encode($response);
}
?>
