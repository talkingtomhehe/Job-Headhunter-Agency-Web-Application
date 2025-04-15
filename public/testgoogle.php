<?php
// Basic test of Google API
require_once '../vendor/autoload.php';
require_once '../app/config/config.php';

try {
    $client = new Google\Client();
    $client->setClientId('475827883823-2unkk5kf7s1avq4gteuql468j8635u6c.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost/huntly/auth/google-callback');
    $client->addScope("email");
    $client->addScope("profile");
    
    // Create the auth URL
    $authUrl = $client->createAuthUrl();
    
    // Debug: Output the URL and exit
    echo "<p>Auth URL: <a href='$authUrl'>$authUrl</a></p>";
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<pre>";
    print_r($e->getTraceAsString());
    echo "</pre>";
}