<?php
require_once "payment.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $phone = $_POST['phone'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if (!$phone || !$amount) {
        echo json_encode(["error" => "Missing phone or amount"]);
        exit;
    }

    $result = requestPayment($phone, $amount);

    echo json_encode($result);
} else {
    echo "Airtel PHP API is running";
}