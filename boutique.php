<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    
    <header class="navbar">

            <!-- logo -->
            <div class="logo">
                <div class="logo-text">
                    <span>Smatbrain</span>
                    <span>Business</span>
                </div>
            </div>

            <!-- navigation -->

            <div class="link">
                <ul>
                    <li><a href="produits.php">Acceuil</a></li>
                    <li><a href="boutique.php">Boutique</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="#">Avis Client</a></li>
                </ul>
            </div>
        </header>   
    
    <!-- <div class="title_boutique">
        <h1>Faites vous plaisir</h1><br><br><br><br>
    </div> -->

         <!-- footer -->
        <footer class="footer">
    <!-- NEWSLETTER -->

        <section class="newsletter">
            <div class="newsletter-icone">
              <i class="fa-solid fa-envelope"></i>
            </div>

            <div class="newsletter-form">
                <input type="email" placeholder="Entrez votre adresse e-mail">
                <button type="submit">
                    S'abonner
                </button>
            </div>
        </section> <br>

        <!-- contenu principal -->

        <section class="footer-content">
            <!-- colonne 1 : nom d'entreprise -->
            
            <div class="footer-column boutique">
                <div class="brand">
                     <!-- <div class="brand-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div> -->

                    <div class="brand-name">
                
                        <h1><i class="fi fi-rr-shopping-cart-add"></i><span style="color: rgb(231, 14, 14);">Smartbrain</span><span style="color: #417eef;">_Business</span></h1>

                        <!-- <span class="boutique-subtitle">
                            informatique et electronique
                        </span> -->

                     </div>
                </div>
                   
                  <!-- descritption -->

                  <h5>Avec Smatbrain_Business, Equipez-vous du meilleurs en
                  matériel électronique et informatique. Qualité,<br>fiabilité et solutions à vos besoin <br>
                    
                </h5><br><br>

                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
            </div>


            <!-- colonne 2: Navigation -->
            <div class="footer-column">
                    <h1>Navigation</h1><br>
                    <ul>
                        <li><a href="produits.php">Accueil</a></li>
                        <li><a href="boutique.php">Boutique</a></li>
                        <li><a href="#">Catégories</a></li>
                        
                    </ul>
            </div>
            
            <!-- colonne 3: catégories -->

            <div class="footer-column">
                <h1>Catégories</h1> <br>
                <ul>
                    <li><a href="#">Ordinateur</a></li>
                    <li><a href="#">Smartphones</a></li>
                    <li><a href="#">Accessoires</a></li>
                    <li><a href="#">Téléphone</a></li>
                    <li><a href="#">éléctronique</a></li>
                </ul>
            </div>


            <!-- colonne 4: entreprise -->
            <diV class="footer-column">

                <h1>Entreprise</h1> <br>
                <ul>
                    <li><a href="#"> A props</a></li>
                    <li><a href="#">Notre blog</a></li>
        
                </ul>
            </diV>

            
                <!-- colonne 5 : paiement -->

                 <div class="footer-column">

                <h1>Paiements</h1> <br>

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


        <section class="footer-bottom">

            <p>
                © 2026  Arman_Business Tous droits réservée.
            </p>

            <div class="currency">
               RDC <span>|</span> USD $
            </div>
        </section>

    </footer>


    <!-- fin footer -->

    
    
</body>
</html>






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
        <h2><?php echo $produit['Nom']; ?></h2>
        <p><?php echo $produit['Description']; ?></p>
        <p><?php echo $produit['Prix']; ?> $</p>
        
        <button>Voir plus</button>
    </div>

<?php } ?>
</div>
</div>
    