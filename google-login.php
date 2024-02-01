<!-- handles google login token verification -->

<?php
require_once 'vendor/autoload.php'; // Composer autoload file

$client = new Google_Client(['client_id' => '936138798104-e109kqpo0rhi60a3pmtgq03l7qm1dlp7.apps.googleusercontent.com']);  // my google login app's client ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_token = $_POST['idtoken'];

    try {
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
            $userid = $payload['sub'];
            echo json_encode(['status' => 'success', 'userid' => $userid]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID token']);
        }

    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo 'Invalid request method.';
}
?>