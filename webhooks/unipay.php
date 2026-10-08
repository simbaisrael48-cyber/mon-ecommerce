
<?php

require "../config/database.php";
require "../config/unipay.php";

// Lire les données envoyées par UniPay
$payload = file_get_contents("php://input");

// Récupérer la signature envoyée par UniPay
$signature = $_SERVER["HTTP_X_UNIPAY_SIGNATURE"] ?? "";

// Calculer la signature attendue
$expected_signature = "sha256=" . hash_hmac(
    "sha256",
    $payload,
    $unipay_webhook_secret
);

// Vérifier la signature
if (
    empty($signature) ||
    !hash_equals($expected_signature, $signature)
) {
    http_response_code(401);
    echo "Signature invalide.";
    exit;
}

// Transformer le JSON en tableau PHP
$data = json_decode($payload, true);

// Vérifier que les données reçues sont valides
if (!is_array($data)) {
    http_response_code(400);
    echo "Données invalides.";
    exit;
}

// Récupérer la référence du paiement
$reference = $data["reference"] ?? null;

// Vérifier que la référence existe
if (empty($reference)) {
    http_response_code(400);
    echo "Référence de paiement manquante.";
    exit;
}

// Chercher la commande correspondante
$sql = "SELECT id, statut_paiement, reference_paiement
        FROM commandes
        WHERE reference_paiement = :reference
        LIMIT 1";

$stmt = $conn->prepare($sql);

$stmt->execute([
    "reference" => $reference
]);

$commande = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier que la commande existe
if (!$commande) {
    http_response_code(404);
    echo "Commande introuvable.";
    exit;
}

if ($reference !== $commande["reference_paiement"]) {
    http_response_code(400);
    echo "Référence de paiement incorrecte.";
    exit;
}
if ($commande["statut_paiement"] === "paye_test") {
    echo "Commande déjà payée.";
    exit;
}
    





// Vérifier le montant et la devise du paiement
$montant_recu = $data["amount"] ?? null;
$devise_recue = $data["currency"] ?? null;

if ($montant_recu === null || empty($devise_recue)) {
    http_response_code(400);
    echo "Montant ou devise manquant.";
    exit;
}

// Taux utilisé dans notre Sandbox
$taux_usd_cdf = 2300;

// Calculer le montant total de la commande en USD
$sql = "SELECT SUM(prix * quantite) AS total_usd
        FROM details_commandes
        WHERE commande_id = :commande_id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    "commande_id" => $commande["id"]
]);

$resultat = $stmt->fetch(PDO::FETCH_ASSOC);



$total_usd = (float) $resultat["total_usd"];

// 
if ($resultat["total_usd"] === null) {
    http_response_code(400);
    echo "Aucun détail trouvé pour cette commande.";
    exit;
}

// Convertir le total en CDF
$montant_attendu = $total_usd * $taux_usd_cdf;

// Vérifier la devise
if ($devise_recue !== "CDF") {
    http_response_code(400);
    echo "Devise incorrecte.";
    exit;
}

// Vérifier le montant
if ((float) $montant_recu != $montant_attendu) {
    http_response_code(400);
    echo "Montant incorrect.";
    exit;
}

// Récupérer le statut envoyé par UniPay
$statut = $data["status"] ?? null;

// Vérifier que le statut existe
if (empty($statut)) {
    http_response_code(400);
    echo "Statut de paiement manquant.";
    exit;
}

// Déterminer le nouveau statut de la commande
if ($statut === "success") {
    $nouveau_statut = "paye_test";
} elseif ($statut === "pending") {
    $nouveau_statut = "en_attente";
} elseif ($statut === "failed") {
    $nouveau_statut = "echec";
} else {
    $nouveau_statut = "en_attente";
}

// Mettre à jour la commande
$sql = "UPDATE commandes
        SET statut_paiement = :statut
        WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    "statut" => $nouveau_statut,
    "id" => $commande["id"]
]);

echo "Statut de la commande mis à jour : " . $nouveau_statut;