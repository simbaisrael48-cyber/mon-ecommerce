<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="navbar">

    <!-- Logo -->
    <div class="logo">
        <div class="logo-text">
            <span>Smartbrain</span>
            <span>Business</span>
        </div>
    </div>

    <!-- Navigation -->
    <div class="link">
        <ul class="nav-links">
            <li><a href="produits.php">Accueil</a> </li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="avis-clients.php">Avis-clients</a></li>
        </ul>
    </div>

</header><br><br><br><br><br><br>
    
<!-- Titre de la boutique -->
<div class="title_boutique">
    <h1>Faites vous <span>plaisir</span></h1><br>

    <p>
        Découvrez notre sélection de matériels informatiques,
        électriques et électroniques.<br>
        Trouvez facilement les équipements adaptés à vos besoins
        et à vos projets.
    </p>
</div>

<!-- PRODUITS -->

<?php

require "config/database.php";

$sql = "SELECT * FROM produits1";
$resultat = $conn->query($sql);

?>

<div class="container">

    <div class="produits">

        <?php while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="produit">

                <img src="images/<?php echo $produit['Image']; ?>">

                <h2>
                    <?php echo $produit['Nom']; ?>
                </h2>

                <p>
                    <?php echo $produit['Description']; ?>
                </p>

                <p>
                    <?php echo $produit['Prix']; ?> $
                </p>

                <form action="panier.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $produit['id']; ?>"
                    >

                    <button
                        class="btn1"
                        type="submit"
                        name="action"
                        value="ajouter"
                    >
                        Ajouter au panier
                    </button>

                </form>

            </div>

        <?php } ?>

    </div>

</div>


<!-- FOOTER -->

<footer class="footer">

    <!-- NEWSLETTER -->
    <section class="newsletter">

        <div class="newsletter-icone">
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="newsletter-form">

            <input
                type="email"
                placeholder="Entrez votre adresse e-mail"
            >

            <button type="submit">
                S'abonner
            </button>

        </div>

    </section>

    <br>

    <!-- CONTENU DU FOOTER -->

    <section class="footer-content">

        <!-- Entreprise -->

        <div class="footer-column boutique">

            <div class="brand">

                <div class="brand-name">

                    <h1>
                        <i class="fi fi-rr-shopping-cart-add"></i>

                        <span style="color: rgb(231, 14, 14);">
                            Smartbrain
                        </span>

                        <span style="color: #417eef;">
                            _Business
                        </span>
                    </h1>

                </div>

            </div>

            <h5>
                Avec Smartbrain_Business, équipez-vous du meilleur
                en matériel électronique et informatique.
                Qualité, fiabilité et solutions à vos besoins.
            </h5>

            <br><br>

            <div class="social-links">

                <a href="#">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>

                <a href="#">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

            </div>

        </div>


        <!-- Navigation -->

        <div class="footer-column">

            <h1>Navigation</h1>

            <br>

            <ul>

                <li>
                    <a href="produits.php">
                        Accueil
                    </a>
                </li>

                <li>
                    <a href="boutique.php">
                        Boutique
                    </a>
                </li>

                <li>
                    <a href="panier.php">
                        Panier
                    </a>
                </li>

                <li>
                    <a href="#">
                        Catégories
                    </a>
                </li>

            </ul>

        </div>


        <!-- Catégories -->

        <div class="footer-column">

            <h1>Catégories</h1>

            <br>

            <ul>

                <li>
                    <a href="#">Ordinateur</a>
                </li>

                <li>
                    <a href="#">Smartphones</a>
                </li>

                <li>
                    <a href="#">Accessoires</a>
                </li>

                <li>
                    <a href="#">Téléphone</a>
                </li>

                <li>
                    <a href="#">Électronique</a>
                </li>

            </ul>

        </div>


        <!-- Entreprise -->

        <div class="footer-column">

            <h1>Entreprise</h1>

            <br>

            <ul>

                <li>
                    <a href="#">
                        À propos
                    </a>
                </li>

                <li>
                    <a href="#">
                        Notre blog
                    </a>
                </li>

            </ul>

        </div>


        <!-- Paiements -->

        <div class="footer-column">

            <h1>Paiements</h1>

            <br>

            <div class="payment-methods">

                <span>
                    <i class="fa-brands fa-cc-visa"></i>
                </span>

                <span>
                    <i class="fa-brands fa-cc-mastercard"></i>
                </span>

                <span>
                    <i class="fa-brands fa-paypal"></i>
                </span>

                <span>
                    <i class="fa-brands fa-apple-pay"></i>
                </span>

                <span class="mobile-money">
                    Mobile Money
                </span>

            </div>

        </div>

    </section>


    <!-- FOOTER BOTTOM -->

    <section class="footer-bottom">

        <p>
            © 2026 Smartbrain_Business.
            Tous droits réservés.
        </p>

        <div class="currency">
            RDC <span>|</span> USD $
        </div>

    </section>

</footer>

</body>
</html>