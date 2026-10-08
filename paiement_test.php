<?php

session_start();

require "config/database.php";

if (empty($_SESSION["panier"])) {
    echo "Le panier est vide.";
    exit;
}

$totalCommande = 0;

$sql = "SELECT * FROM produits1 WHERE id = :id";
$stmt = $conn->prepare($sql);

foreach ($_SESSION["panier"] as $produit1_id => $quantite) {

    $stmt->execute([
        "id" => $produit1_id
    ]);

    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        echo "Produit introuvable.";
        exit;
    }

    $sousTotal = $produit["Prix"] * $quantite;

    $totalCommande += $sousTotal;
}
$taux_usd_cdf = 2300;

$montant_cdf = $totalCommande * $taux_usd_cdf;


echo "<h2>Total de la commande</h2>";

echo "<p>Montant USD : <strong>"
     . number_format($totalCommande, 2, ',', ' ')
     . " $</strong></p>";

echo "<p>Montant CDF : <strong>"
     . number_format($montant_cdf, 0, ',', ' ')
     . " CDF</strong></p>";

