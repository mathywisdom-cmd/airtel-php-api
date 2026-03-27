<?php

require_once "config.php";

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Airtel PHP API is running";
    exit;
}

// Get inputs
$phone = $_POST['phone'] ?? '';
$amount = $_POST['amount'] ?? '';

if (!$phone || !$amount) {
    echo "Missing phone or amount";
    exit;
}

// Airtel API endpoint (TEST)
$url = "https://openapiuat.airtel.africa/merchant/v2/payments/";

// Generate random transaction ID
$transaction_id = uniqid("txn_");

// Prepare payload
$data = [
    "reference" => "Test Payment",
    "subscriber" => [
        "country" => COUNTRY,
        "currency" => CURRENCY,
        "msisdn" => $phone
    ],
    "transaction" => [
        "amount" => $amount,
        "country" => COUNTRY,
        "currency" => CURRENCY,
        "id" => $transaction_id
    ]
];

// Convert to JSON
$json_data = json_encode($data);

// Initialize CURL
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Accept: */*",
    "X-Country: " . COUNTRY,
    "X-Currency: " . CURRENCY,
    "Authorization: Bearer YOUR_ACCESS_TOKEN"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Curl error: " . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);
