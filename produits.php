<?php
require "config/database.php";

$sql = "SELECT * FROM produits1 LIMIT 6";
$resultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Produits - Smartbrain Business</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet"
          href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<!-- NAVIGATION  -->

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


<!-- HERO  -->

<section class="hero">

    <div class="hero-content">

        <h1>
            Tout votre materiel électronique <br>
            et informatique au même endroit <br>
            <span>Facilement</span>.
        </h1><br>

        <p>
            Avec Arman_Business, trouvez tout votre matériel électronique
            et informatique facilement.
            <br>

            Visitez, Commandez vos produits et profitez de la livraison rapide,
            <br>

            le tout en un seul endroit.
        </p>

        <a href="boutique.php" class="hero-btn">
            Découvrir la Boutique
        </a>

    </div>

</section><br><br>


<!-- PRESENTATION -->




<!-- PRODUITS -->

<div class="title">

    <h1>Nos produits</h1><br>
    <p>Parcourez nos produits, consultez leurs détails et ajoutez facilement vos articles préférés à votre panier.<br>

        Notre objectif est de
         vous offrir une expérience d’achat simple, rapide et agréable.</p>

</div>

<br><br>


<section>

    <div class="container">

        <div class="produits">

            <?php while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) { ?>

                <div class="produit">

                    <img
                        src="images/<?php echo htmlspecialchars($produit['Image']); ?>"
                        alt="<?php echo htmlspecialchars($produit['Nom']); ?>"
                    >

                    <h2>
                        <?php echo htmlspecialchars($produit['Nom']); ?>
                    </h2>

                    <p>
                        <?php echo htmlspecialchars($produit['Description']); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($produit['Prix']); ?> $
                    </p>


                    <!-- AJOUT AU PANIER -->

                    <form action="panier.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo htmlspecialchars($produit['id']); ?>"
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

</section>


<!-- SECTION 2 -->

<div class="choisir">
    <h4>
        Pourquoi nous choisir ?
    </h4><br><br>


    <p>
        Nous mettons tout en oeuvre pour vous offrir la meilleure expérience
        d'achat,<br>
        avec des produits de qualités et un service fiable.
    </p>
</div>

<!-- SECTION 4 -->

<section id="section4">


    <div class="icone">

        <br>

        <img
            src="/mon-ecommerce/images/percent-100.svg"
            alt="Produits fiables"
        >

        <h3>
            Des produits fiable et performents
        </h3>

        <p>
            Nous sélectionnons avec soin nos produits informatiques,
            électroniques et électriques afin de vous proposer des
            équipements fiables, performants.
        </p>

    </div>


    <div class="icone">

        <br>

        <img
            src="/mon-ecommerce/images/Médaille.svg"
            alt="Prix compétitifs"
        >

        <h3>
            Des prix accessibles et compétitifs
        </h3>

        <p>
            Nous proposons des produits à des prix accessibles afin de
            permettre à chacun de s'équiper selon ses besoins et son budget.
            Profitez de nos offres compétitives.
        </p>

    </div>


    <div class="icone">

        <br>

        <img
            src="/mon-ecommerce/images/Livraison rapide.svg"
            alt="Livraison rapide"
        >

        <h3>
            Une livraison pratique 24h/24
        </h3>

        <p>
            Nous accordons une grande importance à la rapidité de livraison afin que 
            vous puissiez recevoir vos commandes dans les meilleurs délais.
             
        </p>
    </div>


</section><br>



<section id="section41">


    <div class="iconee">

        <br>

        <img
            src="/mon-ecommerce/images/Support client.svg"
            alt="Produits fiables"
        >

        <h3>
            Des produits fiable et performents
        </h3>

        <p>
            Nous sélectionnons avec soin nos produits informatiques,
            électroniques et électriques afin de vous proposer des
            équipements fiables, performants.
        </p>

    </div>


    <div class="iconee">

        <br>

        <img
            src="/mon-ecommerce/images/securite-des-paiements.svg"
            alt="Prix compétitifs"
        >

        <h3>
            Des prix accessibles et compétitifs
        </h3>

        <p>
            Nous proposons des produits à des prix accessibles afin de
            permettre à chacun de s'équiper selon ses besoins et son budget.
            Profitez de nos offres compétitives.
        </p>

    </div>


    <div class="iconee">

        <br>

        <img
            src="/mon-ecommerce/images/porte-ouverte (1).svg"
            alt="Livraison rapide"
        >

        <h3>
            Une disponilité de 24h/24
        </h3>

        <p>
            Notre boutique en ligne est accessible 24h/24, vous permettant
            de passer vos commandes à tout moment.

            Nous mettons tout en œuvre pour assurer une livraison efficace.
        </p>
    </div>


</section><br><br><br>

<!-- SECTION 3 -->

<section id="section3">

    <br>

    <p>
        Une experience d'achat pensée pour vous.
    </p>

    <h1>
        Découvrez facilement nos produits<br>
        informatique et électronique,<br>
        comparez vos choix et <br>
        commandez en toute simplicité.<br>
        Tout à Kinshasa.
    </h1>

    <br><br><br>

    <button>
        <a href="boutique.php">
            Découvrez nos matériels
        </a>
    </button>

    <br><br>

</section>

<!-- POURQUOI NOUS CHOISIR -->



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


    <!-- CONTENU FOOTER -->

    <section class="footer-content">


        <!-- COLONNE 1 -->

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

                Avec Smatbrain_Business, Equipez-vous du meilleurs en
                matériel électronique et informatique.

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


        <!-- COLONNE 2 -->

        <div class="footer-column">
            <h1>Navigation</h1>
            
            <br>

            <ul>

                <li>
                    <a href="produits.php">Accueil</a>
                
                </li>

                <li>
                    <a href="boutique.php">  Boutique </a>
                    
                </li>

                <li>
                    <a href="panier.php">Panier</a>
                    
                </li>

                <li>
                    <a href="Contact.php">  Contact </a>
                    
                </li>

                <li>
                    <a href="avis-clients.php">Avis-clients</a>
                    
                </li>
            </ul>

        </div>


        <!-- COLONNE 3 -->

        <div class="footer-column">

            <h1>
                Catégories
            </h1>

            <br>

            <ul>

                <li>
                    <a href="#">
                        Informatique
                    </a>
                </li>

                <li>
                    <a href="#">
                        Électronique
                    </a>
                </li>

            </ul>

        </div>

        <!-- COLONNE 5 -->

        <div class="footer-column">

            <h1>
                Paiements
            </h1>

            <br>

            <div class="payment-methods">

                <span  class="mobile-money">
                    Orange Money
                </span>

                <span  class="mobile-money">
                    Airtel Money
                </span>

                <span class="mobile-money">
                    AfriMoney
                </span>

            </div>

        </div>


    </section>


    <!-- BAS DU FOOTER -->

    <section class="footer-bottom">

        <p>
            © 2026 Arman_Business Tous droits réservés.
        </p>

        <div class="currency">

            RDC <span>|</span> USD $

        </div>

    </section>


</footer>


</body>
</html>