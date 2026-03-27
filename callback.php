<?php

// Receive Airtel callback
$data = file_get_contents("php://input");

// Save raw response (for debugging)
file_put_contents("callback_log.txt", $data . PHP_EOL, FILE_APPEND);

// Decode JSON
$response = json_decode($data, true);

// Extract values
$status = $response['data']['transaction']['status'] ?? 'UNKNOWN';
$tx_id = $response['data']['transaction']['id'] ?? '';

// Example logic
if ($status === "SUCCESS") {
    // TODO: Credit user account
    file_put_contents("success.txt", "TX: $tx_id SUCCESS\n", FILE_APPEND);
} else {
    file_put_contents("failed.txt", "TX: $tx_id FAILED\n", FILE_APPEND);
}

// Respond to Airtel
http_response_code(200);
echo "OK";