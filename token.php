<?php
require_once "config.php";

function getAccessToken() {

    $url = BASE_URL . "/auth/oauth2/token";

    $data = [
        "client_id" => CLIENT_ID,
        "client_secret" => CLIENT_SECRET,
        "grant_type" => "client_credentials"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        return ["error" => curl_error($ch)];
    }

    curl_close($ch);

    $result = json_decode($response, true);

    return $result["access_token"] ?? null;
}