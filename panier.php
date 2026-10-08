<?php

session_start();

require "config/database.php";


//
// INITIALISATION DU PANIER
//

if (!isset($_SESSION["panier"])) {
    $_SESSION["panier"] = [];
}


//
// GESTION DES ACTIONS DU PANIER
//

if (
    isset($_POST["action"]) &&
    isset($_POST["id"])
) {

    $id = (int) $_POST["id"];
    $action = $_POST["action"];


    // AJOUTER
    if ($action === "ajouter") {

        if (isset($_SESSION["panier"][$id])) {
            $_SESSION["panier"][$id]++;
        } else {
            $_SESSION["panier"][$id] = 1;
        }

        header("Location: panier.php");
        exit;
    }


    // PLUS
    if ($action === "plus") {

        if (isset($_SESSION["panier"][$id])) {
            $_SESSION["panier"][$id]++;
        }

        header("Location: panier.php");
        exit;
    }


    // MOINS
    if ($action === "moins") {

        if (isset($_SESSION["panier"][$id])) {

            $_SESSION["panier"][$id]--;

            if ($_SESSION["panier"][$id] <= 0) {
                unset($_SESSION["panier"][$id]);
            }
        }

        header("Location: panier.php");
        exit;
    }


    // SUPPRIMER
    if ($action === "supprimer") {

        if (isset($_SESSION["panier"][$id])) {
            unset($_SESSION["panier"][$id]);
        }

        header("Location: panier.php");
        exit;
    }
}


//
// CALCUL DU TOTAL GENERAL
//

$totalPanier = 0;

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Mon panier - Smartbrain Business</title>

    <link rel="stylesheet" href="style.css">


</head>


<body>


<!-- NAVBAR -->

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
            <li><a href="avis-clients.php">Avis-client</a></li>
        </ul>
    </div>
</header>


<!-- TITRE DU PANIER -->

<section class="panier">

    <h1>
        Mon panier
    </h1>

    <br>

    <p>
        Retrouvez ici votre sélection de produits.
        Vérifiez les articles,
        <br>
        les quantités et les prix avant de finaliser
        votre <span>commande.</span>
    </p>

</section>

<br>


<!-- PANIER -->

<?php if (empty($_SESSION["panier"])) { ?>

    <div class="panier-vide">

        <h2>
            Votre panier est vide.
        </h2>

        <br>

        <a href="boutique.php">
            Découvrir nos produits
        </a>

    </div>

<?php } else { ?>


    <?php foreach ($_SESSION["panier"] as $id => $quantite) { ?>


        <?php

        $sql = "SELECT * FROM produits1 WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            "id" => $id
        ]);

        $produit = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$produit) {
            continue;
        }


        $prix = (float) $produit["Prix"];

        $sousTotal = $prix * $quantite;

        $totalPanier += $sousTotal;

        ?>


        <!-- ARTICLE -->

        <div class="article_panier">


            <div>

                <img
                    src="images/<?php echo htmlspecialchars($produit["Image"]); ?>"
                    width="150"
                    alt="<?php echo htmlspecialchars($produit["Nom"]); ?>"
                >

            </div>


            <div class="detail">

                <h2>
                    <?php echo htmlspecialchars($produit["Nom"]); ?>
                </h2>


                <p>

                    Prix :

                    <?php echo htmlspecialchars($produit["Prix"]); ?> $

                </p>


                <p>

                    Quantité :

                    <?php echo $quantite; ?>

                </p>


                <h2>

                    Sous-total :

                    <?php echo number_format($sousTotal, 2); ?> $

                </h2>


                <!-- BOUTONS QUANTITE -->

                <div class="grotte">


                    <!-- MOINS -->

                    <form action="panier.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $id; ?>"
                        >

                        <button
                            class="btn3"
                            type="submit"
                            name="action"
                            value="moins"
                        >
                            −
                        </button>

                    </form>


                    <!-- PLUS -->

                    <form action="panier.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $id; ?>"
                        >

                        <button
                            class="btn3"
                            type="submit"
                            name="action"
                            value="plus"
                        >
                            +
                        </button>

                    </form>


                    <!-- SUPPRIMER -->

                    <form action="panier.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $id; ?>"
                        >

                        <button
                            class="btn2X"
                            type="submit"
                            name="action"
                            value="supprimer"
                        >
                            Supprimer
                        </button>

                    </form>


                </div>


                <br>


                
                <a href="commande.php" class="btn2">Commander</a> 

                <br>
                <br>


                <a href="boutique.php">
                    Continuer vos achats
                </a>


            </div>

        </div>


    <?php } ?>


    <!-- TOTAL GENERAL -->

    <div class="total-panier">

        <h2>
            Total du panier :
            <?php echo number_format($totalPanier, 2); ?> $
        </h2>

    </div>


<?php } ?>

    
</body>

</html>
