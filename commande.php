<?php

session_start();

require "config/database.php";

if (isset($_POST["valider"])) {
    if (empty($_SESSION["panier"])) {
        echo "Votre panier est vide.";
    } else {

// On recupère les informations du formulaire de commande
        try {

            $nom = trim($_POST["nom"]);
            $adresse = trim($_POST["adresse"]);
            $ville = trim($_POST["ville"]);
            $email = trim($_POST["email"]);

//On demare la transaction pour enregistrer la commande
            $conn->beginTransaction();
// On enregistre la commande du client dans la base de données

            $sql = "INSERT INTO commandes
                (nom, email, adresse, ville)
                VALUES
                (:nom, :email, :adresse, :ville)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                "nom" => $nom,
                "email" => $email,
                // "panier" => serialize($_SESSION["panier"]),
                "adresse" => $adresse,
                "ville" => $ville
            ]);
// On recupère l'identifiant de la commade
            $commande_id = $conn->lastInsertId();
// On prepare la regete des produits
            $sqlProduit1 = "SELECT * FROM produits1 WHERE id = :id";
            $stmtProduit1 = $conn->prepare($sqlProduit1);

            $sqlDetail = "INSERT INTO details_commandes 
                            (commande_id, produit1_id, quantite, prix) 
                            VALUES 
                            (:commande_id, :produit1_id, :quantite, :prix)";

            $stmtDetail = $conn->prepare($sqlDetail);
            
// On enregistre les détails de la commande pour chaque produit dans le panier
            foreach ($_SESSION["panier"] as $produit1_id => $quantite) {
                $stmtProduit1->execute([
                    "id" => $produit1_id
                ]);

                $produit = $stmtProduit1->fetch(PDO::FETCH_ASSOC);
                if (!$produit) {
                    throw new Exception("Un des produits du panier est introuvable.");

                }

                $stmtDetail->execute([
                    "commande_id" => $commande_id,
                    "produit1_id" => $produit["id"],
                    "quantite" => $quantite,
                    "prix" => $produit["Prix"]
                ]);
            }

            // On cofirme tous les enregistrement
                $conn->commit();
            // on vide le panier apres réussite
            unset($_SESSION["panier"]);
            
            // On affiche un message de confirmation pour l'utilisateur
            header("Location: commande.php?success=1&id=" . $commande_id);
            exit;  
        } catch (Throwable $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }
            echo "Erreur lors de l'enregistrement de la commande : "
                 . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');

        }
                

    }

}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Commander</title>
</head>

<body>


    <header class="navbar">

    <div class="logo">
        <div class="logo-text">
            <span>Smatbrain</span>
            <span>Business</span>
        </div>
    </div>

    <div class="link">
        <ul class="nav-links">
            <li><a href="produits.php">Accueil</a> </li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="avis-clients.php">Avis-clients</a></li>
        </ul>
    </div>

</header><br><br><br>




    <?php if (isset($_GET["success"], $_GET["id"])) { 
        $commande_id = (int) $_GET["id"];

        $sql = "SELECT p.Nom, p.image, d.quantite, d.prix
               FROM details_commandes d
               INNER JOIN produits1 p ON p.id = d.produit1_id
               WHERE d.commande_id = :commande_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            "commande_id" => $commande_id
        ]);
        $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="confirmation-commande">
            <h2>Commande confirmée !</h2>
            <p>
                Merci pour votre confiance.
                Votre commande a été enregistrée avec succès.
            </p>

            <p>
                Numéro de commande : 
                <strong>
                    <?php echo  htmlspecialchars($_GET["id"]); ?>
                </strong>
            </p>
            <a href="boutique.php">Continuer mes achats</a>
        </div>

    <?php } ?>

    <?php if (!empty($details)): ?>

    <h3>Produits achetés</h3>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Image</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $totalCommande = 0;
        ?>

        <?php foreach ($details as $detail): ?>

            <?php
            $sousTotal = $detail["quantite"] * $detail["prix"];
            $totalCommande += $sousTotal;
            ?>

            <tr>
                <td>
                    <img src="<?= htmlspecialchars($detail["image"]) ?>" 
                    
                    width="100">
                </td>
                <td>
                    <?= htmlspecialchars($detail["Nom"]) ?>
                </td>

                <td>
                    <?= (int) $detail["quantite"] ?>
                </td>

                <td>
                    <?= number_format($detail["prix"], 2, ',', ' ') ?> $
                </td>

                <td>
                    <?= number_format($sousTotal, 2, ',', ' ') ?> $
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th colspan="3">TOTAL DE LA COMMANDE</th>
                <th>
                    <?= number_format($totalCommande, 2, ',', ' ') ?> $
                </th>
            </tr>
        </tfoot>

    </table>

<?php endif; ?>


    <?php
    if (isset($_GET["success"]) && $_GET["success"] == 1) { 
        echo "<p>Votre commande a été enregistrée avec succès !</p>";
    } ?>
      
    

    <section id="commande-section">
        <h2>Passer votre commande</h2>
        <p>Veuillez remplir vos informations pour finaliser votre commande.</p>
    </section>

    <form action="commande.php" method="post">
        <label for="nom">Nom complet :</label><br>
        <input type="text" id="nom" name="nom" required><br>
        
        <label for="email">Email :</label><br>
        <input type="email" id="email" name="email" required><br>
        
       
        <label for="adresse">Adresse :</label><br>
        <input type="text" id="adresse" name="adresse" required><br>

        <label for="ville">Ville :</label><br>
        <input type="text" id="ville" name="ville" required><br><br><br>

        <button type="submit" name="valider">
            Valider la Commande
        </button>
    </form>

    

</body>
</html>