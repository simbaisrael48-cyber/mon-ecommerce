<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>


<!-- NAVIGATION SMARTBRAIN BUSINESS -->
<header class="navbar">

    <div class="logo">
        <div class="logo-text">
            <span>Smartbrain</span>
            <span>Business</span>
        </div>
    </div>

    <!-- Bouton d'ouverture du menu mobile -->
    <button
        class="menu-toggle"
        id="menuToggle"
        type="button"
        aria-label="Ouvrir le menu"
        aria-controls="menuNavigation"
        aria-expanded="false">
        ☰
    </button>

    <!-- Menu de navigation -->
    <div class="link" id="menuNavigation">

        <div class="mobile-menu-header">
            <div class="logo-text">
                <span>Smartbrain</span>
                <span>Business</span>
            </div>

            <button
                class="close-menu"
                id="closeMenu"
                type="button"
                aria-label="Fermer le menu">
                X
            </button>
        </div>

        <ul class="nav-links">
            <li><a href="produits.php">Accueil</a></li>
            <li><a href="boutique.php">Boutique</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="avis-clients.php">Avis clients</a></li>
        </ul>

    </div>
</header>
  
<!-- Titre de la boutique -->
<div class="title_boutique">
    <h1>Bienvenue dans notre <span>boutique</span></h1><br>

    <p>
        Découvrez notre sélection de matériels informatiques,
        électriques et électroniques.<br>
        
        
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
                    <a href="contact.php">
                        Contact
                    </a>
                </li>
                <li>
                    <a href="avis-clients.php">
                        Avis-clients
                    </a>
                </li>

            </ul>

        </div>


        <!-- Catégories -->

        <div class="footer-column">

            <h1>Catégories</h1>

            <br>

            <ul>
                <li><a href="">Informatique</a></li>                 
                <li><a href="#">Électronique</a></li>    
            </ul>

        </div>

        <!-- Paiements -->

        <div class="footer-column">

            <h1>
                Paiements
            </h1>

            <br>
            
            <ul>

                <li>
                    <a href="#">
                        Airtel Money
                    </a>
                </li>

                <li>
                    <a href="#">
                       Orange Money
                    </a>
                </li>

                 <li>
                    <a href="#">
                       Afri Money
                    </a>
                </li>

            </ul>
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