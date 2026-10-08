<?php

session_start();

require "config/database.php";
require "config/unipay.php";

$url = $unipay_url;

if (empty($_SESSION["panier"])) {
    echo "Le panier est vide.";
    exit;
}

$totalCommande = 0;

$sql = "SELECT * FROM produits1 WHERE id = :id";
$stmt = $conn->prepare($sql);

foreach ($_SESSION["panier"] as $produit1_id => $quantite) {
    $stmt->execute(["id" => $produit1_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        echo "Produit introuvable.";
        exit;
    }

    $totalCommande += $produit["Prix"] * $quantite;
}

$taux_usd_cdf = 2300;
$montant_cdf = $totalCommande * $taux_usd_cdf;

$data = [
    "operator" => "orange",
    "direction" => "collect",
    "phone" => "+243812345678",
    "amount" => $montant_cdf,
    "currency" => "CDF",
    "reference" => "TEST-Ecommerce-" . date("YmdHis")
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "X-API-Key: " . $unipay_api_key
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo "Erreur cURL : " . curl_error($ch);
    exit;
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "<h2>Réponse UniPay</h2>";

echo "<p>Code HTTP : " . $http_code . "</p>";

echo "<pre>";
echo htmlspecialchars($response);
echo "</pre>";