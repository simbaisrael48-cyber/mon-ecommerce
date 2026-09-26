<?php

session_start();

require "config/database.php";


if (!isset($_SESSION["panier"])) {

    $_SESSION["panier"] = [];

}



if (
    isset($_POST["action"]) &&
    $_POST["action"] === "ajouter" &&
    isset($_POST["id"])
) {

    $id = (int) $_POST["id"];

    if (isset($_SESSION["panier"][$id])) {
        $_SESSION["panier"][$id]++;
    } else {
        $_SESSION["panier"][$id] = 1;
    }

    header("Location: panier.php");
    exit;
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <title>Mon panier</title>

</head>

<body>

    <header>
            <div class="fixation">
                <nav>
                    <ul class="menu">
                        <li> <a href="produits.php">Accueil</a></li>
                        <li> <a href="boutique.php">Boutique</a></li>
                        <li> <a href="panier.php">Panier</a></li>    
                    
                    </ul>
                </nav>
            </div>
        </header><br><br><br><br>
    
    <div class="panier">
        <h1>Mon panier </h1><br>
        <p>Retrouvez ici votre sélection de produits.
            Vérifiez les articles, <br>les quantités et les prix 
            avant de finaliser votre <span>commande.</span>
        </p>
    </div> <br>
    
    <?php foreach ($_SESSION["panier"] as $id => $quantite) {

    $sql = "SELECT * FROM produits1 WHERE id = :id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        "id" => $id
    ]);

    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        continue;
    }

    $total = 0;


    $prix = (float) $produit["Prix"];

    $sousTotal = $prix * $quantite;

    $total += $sousTotal;

// CALCUL DU BOUTON PLUS
    if (
        isset($_POST["action"]) &&
        $_POST["action"] === "plus" &&
        isset($_POST["id"])
    ) {

        $id = (int) $_POST["id"];

        if (isset($_SESSION["panier"][$id])) {
            $_SESSION["panier"][$id]++;
        }

    header("Location: panier.php");
    exit;
}
// CALCUL DU BOUTON MOINS
if (
    isset($_POST["action"]) &&
    $_POST["action"] === "moins" &&
    isset($_POST["id"])
) {

    $id = (int) $_POST["id"];
    if (isset($_SESSION["panier"][$id])) {

        $_SESSION["panier"][$id]--;

        if ($_SESSION["panier"][$id] <= 0) {
            unset($_SESSION["panier"][$id]);
        }
    }

    header("Location: panier.php");
    exit;
}
// BOUTON SUPPRIMER
if (
    isset($_POST["action"]) &&
    $_POST["action"] === "supprimer" &&
    isset($_POST["id"])
) {

    $id = (int) $_POST["id"];

    if (isset($_SESSION["panier"][$id])) {
        unset($_SESSION["panier"][$id]);
    }

    header("Location: panier.php");
    exit;
}

// Calcul du total du panier


?>

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
                <?php echo $produit["Prix"]; ?> $
            </p>

            <p>
                Quantité :
                <?php echo $quantite; ?>
            </p>

            <h2>
                Total :
                <?php echo $total; ?> $
            </h2>

    <div class="grotte">
            
        <form action="panier.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button class="btn3" type="submit" name="action" value="moins">
                −
            </button>
        </form>

        <form action="panier.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button class="btn3" type="submit" name="action" value="plus">
                +
            </button>
        </form>

        <form action="panier.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button class="btn2X" type="submit" name="action" value="supprimer">
                Supprimer
            </button>
        </form>
    </div>



            <button class="btn2">
                Commander
            </button> <br><br>

            <a href="boutique.php">Continuer votre achat</a>
        </div>
        
    </div>

   
<?php } ?>