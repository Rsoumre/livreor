<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/index.css">
    <title>Livre d'or</title>
</head>
<header>
    <nav class="navbar-custom">
        <li><a href="index.php">Acceuil</a></li>
        <?php if (!isset($_SESSION['id'])): ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        <?php endif; ?>
        <li><a href="livredor.php">Livre d'or</a></li>
        <li><a href="profil.php">Profil</a></li>
        <?php
        if (isset($_SESSION['login'])) {
            echo '<li><a href="commentaire.php">Laissez un commentaire</a></li>' .
                '<li><a href="deconnexion.php">Déconnexion</a></li>';
        }
        ?>
    </nav>
</header>