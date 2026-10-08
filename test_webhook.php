<?php

require "config/unipay.php";

$url = "https://consumers-catalyst-parents-physiology.trycloudflare.com/mon-ecommerce/webhooks/unipay.php";

$data = [
    "transaction_id" => "TEST-123456",
    "status" => "success",
    "amount" => 138000,
    "currency" => "CDF",
    "reference" => "ECOM-20261008000049-6ac6c1110f7e6"
];

$payload = json_encode($data);

$signature = "sha256=" . hash_hmac(
    "sha256",
    $payload,
    $unipay_webhook_secret
);   

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "X-UniPay-Signature: " . $signature
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo "Erreur cURL : " . curl_error($ch);
    exit;
}

curl_close($ch);

echo "<h2>Réponse du webhook</h2>";

echo "<pre>";
echo htmlspecialchars($response);
echo "</pre>";