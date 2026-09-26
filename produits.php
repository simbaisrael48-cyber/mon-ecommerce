


<!-- <link rel="stylesheet" href="style.css">
<div class="produits"> -->


<!-- // while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) { -->

<!-- //     echo "<img src='images/" . $produit["Image"] . "' width='300'>"; -->

<!-- //     echo "<h2>" . $produit["Nom"] . "</h2>"; -->

<!-- //     echo "<p>" . $produit["Description"] . "</p>"; -->

<!-- //     echo "<p>Prix : " . $produit["Prix"] . " $</p>"; -->

<!-- //     echo "<p>Disponibilité : " . $produit["Disponibilité"] . "</p>"; -->

<!-- //     echo "<p>Catégorie : " . $produit["Catégorie"] . "</p>"; -->

<!-- //     echo "<hr>"; -->
<!-- // } -->


<!-- </div> -->

<?php
require "config/database.php";

$sql = "SELECT * FROM produits1 LIMIT 6";
$resultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 
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

         <!-- <div class="image22">
            <img src="/mon-ecommerce/images/GPT.jpg">
        </div> -->
          <section class="hero">
            <div class="hero-content">

                <h1>
                    Tout votre materiel électronique <br>
                    et informatique au même endroit <br>
                    <span>Facilement.</span>
                </h1>

                <p>
                    Avec Arman_Business, trouvez tout votre matériel électronique et informatique facilement. 
                    <br>
                    Visitez, Commandez vos produits et profitez de la livraison rapide,<br>
                    le tout en un seul endroit.
                </p>

              
                    <a href="#" class="hero-btn">
                        Découvrir la Boutique
                    </a>
                
            </div>
        </section>

    </div><br><br><br><br>




    <div class="title">
        <h1>Vos produits</h1>
    </div> <br><br>
    

            <section> 
                <div class="container">

                    <div class="produits">
                        

                        <?php while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) { ?>

                            <div class="produit">

                                <img src="images/<?php echo $produit['Image']; ?>">
                                <h2><?php echo $produit['Nom']; ?></h2>
                                <p><?php echo $produit['Description']; ?></p>
                                <p><?php echo $produit['Prix']; ?> $</p>
                                
                                <button class="btn1">Voir plus</button>
                            </div>

                        <?php } ?>
                        

                    </div> <br> <br><br> <br><br>
                 </div>
            </section><

            <section id="section2">
                <div class="container"> <br> <br>

                    <div class="Equipement">
                         <h2>Equipez-vous. Connectez-vous. <br> Progressez.<br></h2>
                        <p> Ordinateurs, accessoires, outils électronique et équipements professionnels: trouvez tout au même endroit</p>
                    </div>

                     <div class="image">
                         <img src="/mon-ecommerce/images/WhatsApp Image 2026-08-27 at 21.06.47.jpeg">
                    </div>
                </div>
            </section><br><br><br><br><br><br>


        <h4>Pourquoi nous choisir ?</h4><br><br><br><br><br>
        <section id="section3">
            <div class="icone">
                <img src="/mon-ecommerce/images/percent-100.svg" alt="point"><br>
                <h3>Produit de qualité</h3>
                <h5>Des produits fiable et performents</h5>
            </div>
            <div class="icone">
               <img src="/mon-ecommerce/images/Médaille.svg" alt="médaille"><br>
               <h3>Prix compétitifs</h3> 
               <h5>Les meilleurs prix du marché</h5>
            </div>
            <div class="icone">
                <img src="/mon-ecommerce/images/Livraison rapide.svg" alt="Livraison"><br>
                <h3>Livraison rapide</h3>
                <h5>Livraison partout à votre porte</h5>
            </div>
            <div class="icone">
                <img src="/mon-ecommerce/images/securite-des-paiements.svg" alt="paiement sécurisé"><br>
                <h3>Paiement sécurisé</h3>
                <h5>Transaction 100% sécurisées</h5>
            </div>
            <div class="icone">
                <img src="/mon-ecommerce/images/Support client.svg" alt="support client"><br>
                <h3>Support client</h3>
                <h5>Assistance dédiée 7j/7  </h5>
            </div>
        </section>
    </main><br><br><br><br><br><br><br><br>


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













