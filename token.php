<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";

$url = "https://openapiuat.airtel.africa/auth/oauth2/token";

$data = [
    "client_id" => CLIENT_ID,
    "client_secret" => CLIENT_SECRET,
    "grant_type" => "client_credentials"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: */*"
]);

$response = curl_exec($ch);

// Show CURL error if exists
if (curl_errno($ch)) {
    echo "CURL ERROR: " . curl_error($ch);
} else {
    echo "RESPONSE: " . $response;
}

curl_close($ch);
