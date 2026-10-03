<?php
require_once "config/database.php";

$message = "";

/* ENREGISTRER UN AVIS */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"] ?? "");
    $note = (int)($_POST["note"] ?? 0);
    $commentaire = trim($_POST["commentaire"] ?? "");

    if ($nom !== "" && $note >= 1 && $note <= 5 && $commentaire !== "") {

        $sql = "INSERT INTO avis_clients (nom, note, commentaire)
                VALUES (:nom, :note, :commentaire)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ":nom" => $nom,
            ":note" => $note,
            ":commentaire" => $commentaire
        ]);

        $message = "Merci pour votre avis !";
    } else {
        $message = "Veuillez remplir correctement tous les champs.";
    }
}


/* RÉCUPÉRER LES AVIS */
$stmtAvis = $conn->query(
    "SELECT nom, note, commentaire, date_avis
     FROM avis_clients
     ORDER BY date_avis DESC"
);

$avis = $stmtAvis->fetchAll(PDO::FETCH_ASSOC);


/* CALCULER LA NOTE MOYENNE */
$stmtMoyenne = $conn->query(
    "SELECT AVG(note) AS moyenne, COUNT(*) AS total
     FROM avis_clients"
);

$statistiques = $stmtMoyenne->fetch(PDO::FETCH_ASSOC);

$moyenne = $statistiques["moyenne"] ?? 0;
$totalAvis = $statistiques["total"] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Avis clients | Votre entreprise</title>

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
            <li><a href="avis-clients.php">Avis-client</a></li>
            
        </ul>
    </div>

</header>

    <main>

        <!- HERO -- >
        <section class="avis-hero">

            <p class="sur-titre">L'EXPÉRIENCE DE NOS CLIENTS</p>

            <h1>
                Ce que nos clients
                <span>pensent de nous</span>
            </h1>

            <p class="hero-description">
                Votre satisfaction est au cœur de notre engagement.
                Découvrez les expériences de nos clients et partagez
                vous aussi la vôtre.
            </p>

        </section>


        <!- STATISTIQUES-- >
        <section class="avis-statistiques">

            <div class="statistique">

                <div class="grande-note">
                    <?php echo number_format((float)$moyenne, 1); ?>
                </div>

                <div class="etoiles">
                    ★★★★★
                </div>

                <p>Note moyenne</p>

            </div>


            <div class="statistique">

                <div class="grande-note">
                    <?php echo $totalAvis; ?>
                </div>

                <p>Avis clients</p>

            </div>

        </section>


        <!- FORMULAIRE ->
        <section class="avis-formulaire">

            <div class="titre-section">

                <p class="sur-titre">VOTRE EXPÉRIENCE</p>

                <h2>
                    Partagez votre avis
                </h2>

                <p>
                    Votre opinion nous aide à améliorer continuellement
                    notre service.
                </p>

            </div>


            <?php if ($message !== ""): ?>

                <div class="message">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="champ">

                    <label for="nom">
                        Votre nom
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        placeholder="Entrez votre nom"
                        required
                    >

                </div>


                <div class="champ">

                    <label for="note">
                        Votre note
                    </label>

                    <select
                        id="note"
                        name="note"
                        required
                    >

                        <option value="">
                            Sélectionnez une note
                        </option>

                        <option value="5">
                            ★★★★★ — Excellent
                        </option>

                        <option value="4">
                            ★★★★☆ — Très bien
                        </option>

                        <option value="3">
                            ★★★☆☆ — Bien
                        </option>

                        <option value="2">
                            ★★☆☆☆ — Moyen
                        </option>

                        <option value="1">
                            ★☆☆☆☆ — À améliorer
                        </option>

                    </select>

                </div>


                <div class="champ">

                    <label for="commentaire">
                        Votre avis
                    </label>

                    <textarea
                        id="commentaire"
                        name="commentaire"
                        rows="5"
                        placeholder="Dites-nous ce que vous pensez de votre expérience..."
                        required ></textarea>

                </div>


                <button type="submit">
                    Publier mon avis
                    <span>→</span>
                </button>

            </form>

        </section>


        <!-- AVIS DES CLIENTS -->
        <section class="liste-avis">

            <div class="titre-section">

                <p class="sur-titre">TÉMOIGNAGES</p>

                <h2>
                    Ils nous font confiance
                </h2>

            </div>


            <div class="cartes-avis">

                <?php if (count($avis) > 0): ?>

                    <?php foreach ($avis as $client): ?>

                        <article class="carte-avis">

                            <div class="avis-entete">

                                <div class="avatar">

                                    <?php
                                    echo strtoupper(
                                        substr($client["nom"], 0, 1)
                                    );
                                    ?>

                                </div>

                                <div>

                                    <h3>
                                        <?php
                                        echo htmlspecialchars(
                                            $client["nom"]
                                        );
                                        ?>
                                    </h3>

                                    <div class="etoiles-client">

                                        <?php
                                        echo str_repeat(
                                            "★",
                                            (int)$client["note"]
                                        );

                                        echo str_repeat(
                                            "☆",
                                            5 - (int)$client["note"]
                                        );
                                        ?>

                                    </div>

                                </div>

                            </div>


                            <p class="commentaire">

                                «
                                <?php
                                echo htmlspecialchars(
                                    $client["commentaire"]
                                );
                                ?>
                                »

                            </p>


                            <small>

                                <?php
                                echo date(
                                    "d/m/Y",
                                    strtotime($client["date_avis"])
                                );
                                ?>

                            </small>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p class="aucun-avis">
                        Soyez le premier à partager votre expérience.
                    </p>

                <?php endif; ?>

            </div>

        </section>

    </main>

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

            <h1>
                Navigation
            </h1>

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


        <!-- COLONNE 3 -->

        <div class="footer-column">

            <h1>
                Catégories
            </h1>

            <br>

            <ul>

                <li>
                    <a href="#">
                        Ordinateur
                    </a>
                </li>

                <li>
                    <a href="#">
                        Smartphones
                    </a>
                </li>

                <li>
                    <a href="#">
                        Accessoires
                    </a>
                </li>

                <li>
                    <a href="#">
                        Téléphone
                    </a>
                </li>

                <li>
                    <a href="#">
                        Électronique
                    </a>
                </li>

            </ul>

        </div>


        <!-- COLONNE 4 -->

        <div class="footer-column">

            <h1>Entreprise </h1>    
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


        <!-- COLONNE 5 -->

        <div class="footer-column">

            <h1>
                Paiements
            </h1>

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