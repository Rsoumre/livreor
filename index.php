<?php
// On démarre la session pour pouvoir utiliser $_SESSION (utile pour connexion, affichage pseudo, etc.)
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <!-- Compatibilité IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Responsive mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Polices Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neonderthaw&family=Qwigley&family=Dancing+Script&family=Merriweather&display=swap" rel="stylesheet">

    <!-- Feuille de style personnalisée -->
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Accueil - Livre d'or</title>
</head>

<body>
    <!-- Inclusion du header (navigation/menu) -->
    <?php include 'layout/header.php'; ?>
    <!-- Section principale : présentation du Livre d'or -->
    <article>
        <h3>Livre d'or</h3>
        <p>
            Bienvenue dans notre Livre d'or ! Ici, vous pouvez partager vos impressions, vos encouragements 
            ou simplement laisser un mot pour soutenir notre équipe.<br>
            Vos messages resteront un souvenir précieux pour nous tous !
        </p>

<!-- Section principale : présentation du Livre d'or avec 3 cartes -->
<section class="accueil-cards">
    <div class="card">
        <img src="assets/img/img-1.avif" alt="Card 1">
        <div class="card-content">
            <h4>Bienvenue</h4>
            <p>Partagez vos impressions et laissez un mot pour soutenir notre équipe.</p>
        </div>
    </div>

    <div class="card">
        <img src="assets/img/img-2.jpg" alt="Card 2">
        <div class="card-content">
            <h4>Souvenirs</h4>
            <p>Retrouvez les messages de tous ceux qui ont participé à notre aventure.</p>
        </div>
    </div>

    <div class="card">
        <img src="assets/img/img-3.jpg" alt="Card 3">
        <div class="card-content">
            <h4>Inspiration</h4>
            <p>Laissez une trace de votre passage et contribuez à notre livre d'or.</p>
        </div>
    </div>
</section>

    </article>

    <!-- Footer -->
    <footer>
        <p> © Livre d'or - Tous droits réservés.</p>
    </footer>
</body>
</html>
