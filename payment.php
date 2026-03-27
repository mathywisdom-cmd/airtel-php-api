<?php
require_once "config.php";
require_once "token.php";

function requestPayment($phone, $amount) {

    $token = getAccessToken();

    if (!$token) {
        return ["error" => "Failed to get token"];
    }

    $url = BASE_URL . "/merchant/v2/payments/";

    $payload = [
        "reference" => "Airtel Payment",
        "subscriber" => [
            "country" => COUNTRY,
            "currency" => CURRENCY,
            "msisdn" => $phone
        ],
        "transaction" => [
            "amount" => $amount,
            "country" => COUNTRY,
            "currency" => CURRENCY,
            "id" => uniqid()
        ],
        "callback_url" => CALLBACK_URL
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: */*",
        "Content-Type: application/json",
        "X-Country: " . COUNTRY,
        "X-Currency: " . CURRENCY,
        "Authorization: Bearer " . $token
        // Encryption headers will be added later for LIVE
    ]);

    $response = curl_exec($ch);

    if(curl_errno($ch)){
        return ["error" => curl_error($ch)];
    }

    curl_close($ch);

    return json_decode($response, true);
}