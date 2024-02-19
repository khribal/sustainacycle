<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://cgi.luddy.indiana.edu/~team20/login-files/login-2.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>
