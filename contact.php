<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
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

    <section id="section_contact">

    <br>

    <p>
        Support technique.
    </p>

    <h1>
        Une question ? <br> Contactez-nous, nous sommes à votre écoute.
    </h1>

    <br><br><br>

    <button>
        <a href="boutique.php">
            Discuter sur WhatsApp
        </a>
    </button>

    <br><br><br>

    </section>

    <section id="contact">
        <div class="div1">
            <h2>Ecrivez-nous</h2>
            <p>Vous avez une question concernant nos produits, une commande,
                une livraison, ou nos services, n'hésitez pas à nous contacter.<br>
                Notre équipe est disponible pour vous accompagner et vous apporter
                une réponse claire et rapide.
            </p>
        </div>
           
        <form class="form1" action="commande.php" method="post">
            <label for="nom">Nom :</label><br>
            <input type="text" id="nom" name="nom" required><br>

            <label for="adresse">Email :</label><br>
            <input type="email" id="adresse" name="adresse" required><br>

            <label for="message">Message :</label><br>
            <textarea id="message" name="message" required></textarea><br><br>

            <button  class="btn4" type="submit" name="valider">
                <a href="contact.php"></a>Envoyer le Message
            </button>
        </form>

    </section><br><br><br><br><br><br>


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