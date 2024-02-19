<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Get the raw POST data 
    $content = trim(file_get_contents("php://input")); 
    $decoded = json_decode($content, true); 
    
    // Check if decoding was successful 
    if(is_array($decoded)) { 
        $id_token = $decoded['id_token']; 
        $name = $decoded['name']; 
        $email = $decoded['email']; 
        
        // Example: Return a JSON response 
        echo json_encode(['success' => true]); 
    } else { 
        echo json_encode(['error' => 'Invalid JSON.']); 
    }} 
else { 
        // Handle the case where the request method is not POST 
        echo json_encode(['error' => 'POST data not received.']); 
}

$json_error = json_last_error(); if ($json_error != JSON_ERROR_NONE) { echo json_encode(['error' => 'JSON decode error: ' . $json_error]); }
?>
