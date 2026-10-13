<?php

session_start();

require "config/database.php";
require "config/unipay.php";


// ======================================================
// 1. VALIDATION DE LA COMMANDE
// ======================================================

if (isset($_POST["valider"])) {

    if (empty($_SESSION["panier"])) {

        echo "Votre panier est vide.";

    } else {

        try {

            // ------------------------------------------
            // Récupération des informations du formulaire
            // ------------------------------------------

            $nom = trim($_POST["nom"]);
            $adresse = trim($_POST["adresse"]);
            $ville = trim($_POST["ville"]);
            $email = trim($_POST["email"]);

            $moyen_paiement = trim($_POST["moyen_paiement"]);

            $numero_paiement = trim($_POST["numero_paiement"]);

// Supprimer les espaces dans le numéro
$numero_paiement = preg_replace('/\s+/', '', $numero_paiement);

// Vérifier le format du numéro RDC
if (!preg_match('/^(?:\+243|0)[0-9]{9}$/', $numero_paiement)) {
    throw new Exception(
        "Numéro Mobile Money invalide. Utilisez par exemple +243812345678 ou 0812345678."
    );
}

// Convertir le format local en format international
if (preg_match('/^0[0-9]{9}$/', $numero_paiement)) {
    $numero_paiement = '+243' . substr($numero_paiement, 1);
}


            // ------------------------------------------
            // Vérification du moyen de paiement
            // ------------------------------------------

            if (empty($moyen_paiement)) {

                throw new Exception(
                    "Veuillez choisir un moyen de paiement."
                );
            }


            // ------------------------------------------
            // Vérification du numéro de paiement
            // ------------------------------------------

            if (empty($numero_paiement)) {

                throw new Exception(
                    "Veuillez entrer votre numéro Mobile Money."
                );
            }


            // ==================================================
            // 2. CALCUL DU TOTAL DE LA COMMANDE
            // ==================================================

            $totalCommande = 0;

            $sqlProduit1 = "SELECT * FROM produits1 WHERE id = :id";

            $stmtProduit1 = $conn->prepare($sqlProduit1);


            foreach ($_SESSION["panier"] as $produit1_id => $quantite) {

                $stmtProduit1->execute([
                    "id" => $produit1_id
                ]);

                $produit = $stmtProduit1->fetch(PDO::FETCH_ASSOC);


                if (!$produit) {

                    throw new Exception(
                        "Un des produits du panier est introuvable."
                    );
                }


                $totalCommande +=
                    $produit["Prix"] * $quantite;
            }


            // ==================================================
            // 3. CONVERSION USD → CDF
            // ==================================================

            // Taux de test
            $taux_usd_cdf = 2300;

            $montant_cdf =
                (int) round($totalCommande * $taux_usd_cdf);


            // Vérification du montant
            if ($montant_cdf <= 0) {

                throw new Exception(
                    "Le montant de la commande est invalide."
                );
            }


            // ==================================================
            // 4. DÉTERMINATION DE L'OPÉRATEUR UNIPAY
            // ==================================================

            $operator = "";


            if ($moyen_paiement === "Orange Money") {

                $operator = "orange";

            } elseif ($moyen_paiement === "Airtel Money") {

                $operator = "airtel";

            } elseif ($moyen_paiement === "Afrimoney") {

                $operator = "afrimoney";

            } else {

                throw new Exception(
                    "Moyen de paiement invalide."
                );
            }


            // ==================================================
            // 5. CRÉATION D'UNE RÉFÉRENCE UNIQUE
            // ==================================================

            $reference_paiement =
                "ECOM-" .
                date("YmdHis") .
                "-" .
                uniqid();


            // ==================================================
            // 6. PRÉPARATION DES DONNÉES POUR UNIPAY
            // ==================================================

            $data = [

                "operator" => $operator,

                "direction" => "collect",

                "phone" => $numero_paiement,

                "amount" => $montant_cdf,

                "currency" => "CDF",

                "reference" => $reference_paiement
            ];


            // ==================================================
            // 7. ENVOI DE LA DEMANDE À UNIPAY
            // ==================================================

            $ch = curl_init($unipay_url);


            curl_setopt($ch, CURLOPT_POST, true);


            curl_setopt($ch, CURLOPT_HTTPHEADER, [

                "Content-Type: application/json",

                "X-API-Key: " . $unipay_api_key
            ]);


            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                json_encode($data)
            );


            curl_setopt(
                $ch,
                CURLOPT_RETURNTRANSFER,
                true
            );


            curl_setopt(
                $ch,
                CURLOPT_TIMEOUT,
                30
            );


            // Exécution de la requête
            $response = curl_exec($ch);


            // ------------------------------------------
            // Vérification de cURL
            // ------------------------------------------

            if ($response === false) {

                throw new Exception(
                    "Erreur de connexion à UniPay : "
                    . curl_error($ch)
                );
            }


            // ------------------------------------------
            // Récupération du code HTTP
            // ------------------------------------------

            $http_code =
                curl_getinfo(
                    $ch,
                    CURLINFO_HTTP_CODE
                );


            curl_close($ch);


            // ==================================================
            // 8. LECTURE DE LA RÉPONSE UNIPAY
            // ==================================================

            $unipay_response =
                json_decode(
                    $response,
                    true
                );

            if (!is_array($unipay_response)) {
                throw new Exception("Réponse UniPay invalide.");
            }

            if ($http_code >= 200 && $http_code < 300) {

                if (
                    isset($unipay_response["status"])
                    && $unipay_response["status"] === "success"
                ) {
                    $statut_paiement = "paye_test";
                } else {
                    $statut_paiement = "en_attente";
                }

            } else {
                throw new Exception(
                    "Erreur UniPay. Code HTTP : " . $http_code
                );
            }

            if (!is_array($unipay_response)) {

                throw new Exception(
                    "Réponse UniPay invalide."
                );
            }


            // ------------------------------------------
            // Vérification du code HTTP
            // ------------------------------------------

            if (
                $http_code < 200 ||
                $http_code >= 300
            ) {

                $message =
                    $unipay_response["message"]
                    ?? "Erreur lors de la communication avec UniPay.";

                throw new Exception($message);
            }


            // ==================================================
            // 9. DÉTERMINATION DU STATUT DU PAIEMENT
            // ==================================================

            if (
                isset($unipay_response["status"]) &&
                $unipay_response["status"] === "success"
            ) {

                // Sandbox UniPay
                $statut_paiement = "paye_test";

            } else {

                $statut_paiement = "en_attente";
            }


            // ==================================================
            // 10. ENREGISTREMENT DE LA COMMANDE
            // ==================================================

            $conn->beginTransaction();


            $sql = "INSERT INTO commandes
                    (
                        nom,
                        email,
                        adresse,
                        ville,
                        moyen_paiement,
                        numero_paiement,
                        statut_paiement,
                        reference_paiement
                    )
                    VALUES
                    (
                        :nom,
                        :email,
                        :adresse,
                        :ville,
                        :moyen_paiement,
                        :numero_paiement,
                        :statut_paiement,
                        :reference_paiement
                    )";


            $stmt = $conn->prepare($sql);


            $stmt->execute([

                "nom" =>
                    $nom,

                "email" =>
                    $email,

                "adresse" =>
                    $adresse,

                "ville" =>
                    $ville,

                "moyen_paiement" =>
                    $moyen_paiement,

                "numero_paiement" =>
                    $numero_paiement,

                "statut_paiement" =>
                    $statut_paiement,

                "reference_paiement" =>
                    $reference_paiement
            ]);


            // ==================================================
            // 11. RÉCUPÉRATION DE L'ID DE LA COMMANDE
            // ==================================================

            $commande_id =
                $conn->lastInsertId();


            // ==================================================
            // 12. ENREGISTREMENT DES PRODUITS COMMANDÉS
            // ==================================================

            $sqlProduit1 =
                "SELECT * FROM produits1 WHERE id = :id";


            $stmtProduit1 =
                $conn->prepare($sqlProduit1);


            $sqlDetail =
                "INSERT INTO details_commandes
                (
                    commande_id,
                    produit1_id,
                    quantite,
                    prix
                )
                VALUES
                (
                    :commande_id,
                    :produit1_id,
                    :quantite,
                    :prix
                )";


            $stmtDetail =
                $conn->prepare($sqlDetail);


            foreach (
                $_SESSION["panier"]
                as $produit1_id => $quantite
            ) {

                $stmtProduit1->execute([

                    "id" =>
                        $produit1_id
                ]);


                $produit =
                    $stmtProduit1->fetch(
                        PDO::FETCH_ASSOC
                    );


                if (!$produit) {

                    throw new Exception(
                        "Un des produits du panier est introuvable."
                    );
                }


                $stmtDetail->execute([

                    "commande_id" =>
                        $commande_id,

                    "produit1_id" =>
                        $produit["id"],

                    "quantite" =>
                        $quantite,

                    "prix" =>
                        $produit["Prix"]
                ]);
            }


            // ==================================================
            // 13. VALIDATION DE LA TRANSACTION MYSQL
            // ==================================================

            $conn->commit();


            // ==================================================
            // 14. VIDAGE DU PANIER
            // ==================================================

            unset($_SESSION["panier"]);


            // ==================================================
            // 15. REDIRECTION VERS LA CONFIRMATION
            // ==================================================

            header(
                "Location: commande.php?success=1&id="
                . $commande_id
                . "&paiement=1"
            );

            exit;


        } catch (Throwable $e) {

            // Annulation de la transaction MySQL
            if ($conn->inTransaction()) {

                $conn->rollBack();
            }


            echo "<div style='
                    max-width:700px;
                    margin:30px auto;
                    padding:20px;
                    background:#ffe5e5;
                    color:#a00000;
                    border-radius:10px;
                    font-family:Arial;
                  '>";

            echo "<strong>Erreur :</strong><br>";

            echo htmlspecialchars(
                $e->getMessage(),
                ENT_QUOTES,
                "UTF-8"
            );

            echo "</div>";
        }
    }
}


// ======================================================
// 16. ANCIENNE SIMULATION DE PAIEMENT
// ======================================================


?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <script src="script.js" defer></script>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Passer la commande</title>

</head>
<body>
    <header class="navbar">

    <div class="logo">
        <div class="logo-text">
            <span>Smatbrain</span>
            <span>Business</span>
        </div>
    </div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <div class="link">
        <ul class="nav-links">
            <li><a href="produits.php">Accueil</a> </li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="avis-clients.php">Avis-client</a></li>
            
        </ul>
    </div>

</header>

<div class="commande-container">

    <div class="commande-box">

        <h1>Passer votre commande</h1>


        <?php

       
        //  AFFICHAGE DE LA CONFIRMATION
       

        if (
            isset($_GET["success"]) &&
            $_GET["success"] == 1
        ) {

            $commande_id =
                isset($_GET["id"])
                ? (int) $_GET["id"]
                : 0;


            if ($commande_id > 0) {

                $sqlConfirmation =
                    "SELECT *
                     FROM commandes
                     WHERE id = :id";


                $stmtConfirmation =
                    $conn->prepare(
                        $sqlConfirmation
                    );


                $stmtConfirmation->execute([

                    "id" =>
                        $commande_id
                ]);


                $commande =
                    $stmtConfirmation->fetch(
                        PDO::FETCH_ASSOC
                    );


                if ($commande) {

                    ?>

                    <div class="confirmation">

                        <h2>
                            Commande enregistrée avec succès !
                        </h2>

                        <p>
                            Merci
                            <strong>
                                <?= htmlspecialchars(
                                    $commande["Nom"]
                                    ?? $commande["nom"]
                                ) ?>
                            </strong>
                            pour votre commande.
                        </p>

                        <p>
                            Numéro de commande :
                            <strong>
                                #<?= htmlspecialchars(
                                    $commande["id"]
                                ) ?>
                            </strong>
                        </p>

                        <p>
                            Moyen de paiement :
                            <strong>
                                <?= htmlspecialchars(
                                    $commande["moyen_paiement"]
                                ) ?>
                            </strong>
                        </p>

                        <?php
if ($commande["statut_paiement"] === "paye_test") {
    $statut_affiche = "Paiement réussi";
} elseif ($commande["statut_paiement"] === "en_attente") {
    $statut_affiche = "Paiement en attente";
} elseif ($commande["statut_paiement"] === "echec") {
    $statut_affiche = "Paiement échoué";
} else {
    $statut_affiche = "Statut inconnu";
}
?>

                        <p>
                            Statut du paiement :
                            <strong>
                                <?= htmlspecialchars($statut_affiche) ?>
                            </strong>
                        </p>

                        <p>
                            Référence :
                            <strong>
                                <?= htmlspecialchars(
                                    $commande["reference_paiement"]
                                ) ?>
                            </strong>
                        </p>


                        <?php

                        if (
                            $commande["statut_paiement"]
                            === "paye_test"
                        ) {

                            ?>

                            <div class="paiement-ok">

                                ✅ Paiement Sandbox UniPay réussi.

                                <br>

                                Votre commande a été enregistrée.

                            </div>

                            <?php

                        }

                        ?>

                    </div>

                    <?php
                }
            }
        }

        ?>


        <?php

        // ==================================================
        // AFFICHAGE DU PANIER AVANT COMMANDE
        // ==================================================

        if (
            !isset($_GET["success"]) &&
            !empty($_SESSION["panier"])
        ) {

            ?>

            <h2>Votre panier</h2>


            <table class="produit-commande">

                <thead>

                    <tr>

                        <th>Produit</th>

                        <th>Prix</th>

                        <th>Quantité</th>

                        <th>Sous-total</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $totalCommande = 0;


                $sql =
                    "SELECT *
                     FROM produits1
                     WHERE id = :id";


                $stmt =
                    $conn->prepare($sql);


                foreach (
                    $_SESSION["panier"]
                    as $produit1_id => $quantite
                ) {

                    $stmt->execute([

                        "id" =>
                            $produit1_id
                    ]);


                    $produit =
                        $stmt->fetch(
                            PDO::FETCH_ASSOC
                        );


                    if ($produit) {

                        $sousTotal =
                            $produit["Prix"]
                            * $quantite;


                        $totalCommande +=
                            $sousTotal;

                        ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars(
                                    $produit["Nom"]
                                ) ?>
                            </td>

                            <td>
                                <?= number_format(
                                    $produit["Prix"],
                                    2,
                                    ",",
                                    " "
                                ) ?>
                                $
                            </td>

                            <td>
                                <?= (int) $quantite ?>
                            </td>

                            <td>
                                <?= number_format(
                                    $sousTotal,
                                    2,
                                    ",",
                                    " "
                                ) ?>
                                $
                            </td>

                        </tr>

                        <?php
                    }
                }

                ?>

                </tbody>

            </table>


            <?php

            $taux_usd_cdf = 2300;

            $montant_cdf =
                (int) round(
                    $totalCommande
                    * $taux_usd_cdf
                );

            ?>


            <div class="paiement-ok">

                <strong>
                    Total :
                </strong>

                <?= number_format(
                    $totalCommande,
                    2,
                    ",",
                    " "
                ) ?>

                $

                <br>

                <strong>
                    Équivalent :
                </strong>

                <?= number_format(
                    $montant_cdf,
                    0,
                    ",",
                    " "
                ) ?>

                CDF

            </div>


            <br>


            <!-- ==================================================
                 FORMULAIRE DE COMMANDE
                 ================================================== -->

            <form
                method="POST"
                action="commande.php"
            >


                <div class="form-group">

                    <label for="nom">
                        Nom complet
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Adresse e-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="adresse">
                        Adresse
                    </label>

                    <input
                        type="text"
                        id="adresse"
                        name="adresse"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="ville">
                        Ville
                    </label>

                    <input
                        type="text"
                        id="ville"
                        name="ville"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="moyen_paiement">
                        Moyen de paiement
                    </label>

                    <select
                        id="moyen_paiement"
                        name="moyen_paiement"
                        required
                    >

                        <option value="">
                            -- Choisir un moyen de paiement --
                        </option>

                        <option value="Orange Money">
                            Orange Money
                        </option>

                        <option value="Airtel Money">
                            Airtel Money
                        </option>

                        <option value="Afrimoney">
                            Afrimoney
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="numero_paiement">
                        Numéro Mobile Money
                    </label>

                    <input
                        type="text"
                        id="numero_paiement"
                        name="numero_paiement"
                        placeholder="+243812345678"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="valider"
                    class="btn-commande"
                >

                    Payer et valider la commande

                </button>


            </form>


            <?php
        }

        ?>


        <?php

        // ==================================================
        // ANCIEN BOUTON DE SIMULATION
        // ==================================================

        if (
            isset($_GET["success"]) &&
            $_GET["success"] == 1 &&
            isset($_GET["id"])
        ) {

            $commande_id =
                (int) $_GET["id"];


            $sql =
                "SELECT statut_paiement
                 FROM commandes
                 WHERE id = :id";


            $stmt =
                $conn->prepare($sql);


            $stmt->execute([

                "id" =>
                    $commande_id
            ]);


            $commande =
                $stmt->fetch(
                    PDO::FETCH_ASSOC
                );


            if (
                $commande &&
                $commande["statut_paiement"]
                !== "paye_test"
            ) {

                ?>

                <div class="simulation">

                    <form
                        method="POST"
                        action="commande.php"
                    >

                        <input
                            type="hidden"
                            name="commande_id"
                            value="<?= $commande_id ?>"
                        >

                        <button
                            type="submit"
                            name="simuler_paiement"
                        >

                            Simuler le paiement

                        </button>

                    </form>

                </div>

                <?php
            }
        }

        ?>

    </div>

</div>


</body>

</html>