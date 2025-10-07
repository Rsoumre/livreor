<?php
session_start();
$session_timeout = 1800;

//  si la session existe et si elle a expiré
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout) {
        // Si la session a expiré, on la détruit et redirige vers la page de connexion avec paramètre timeout
        session_unset();
        session_destroy();
        header('Location: connexion.php?timeout=1');
        exit();
    }
}

// Mise à jour du timestamp de dernière activité
$_SESSION['LAST_ACTIVITY'] = time();
include "config/serveur.php";

// d'erreurms
$error = null;

//  formulairem
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $bdd->real_escape_string($_POST['login']); // sécurisation du login
    $password = $_POST['password'];

    // Requête  récupérer  login
    $result = $bdd->query("SELECT * FROM utilisateurs WHERE login = '$login'");

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();

        //  vu mot de passe 
        if (password_verify($password, $user['password'])) {
        
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];

            // Redirection vers le profil
            header('Location: profil.php');
            exit();
        } else {
            $error = "Login ou mot de passe incorrect";
        }
    } else {
        $error = "Login ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/connexion.css">

    <title>Connexion - Livre d'or</title>
</head>

<body class="fond2">
    <!-- Inclusion du header (menu) -->
    <?php include 'layout/header.php'; ?>

    <main>

        <section>
             <h2>Connexion</h2> <!-- Titre à l'intérieur de la card -->
            <!-- Formulaire de connexion -->
            <form action="connexion.php" method="post" class="form-card">
                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" name="login" placeholder="Login" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Valider" name="valid" class="btn btn-primary">
                </div>
            </form>

            <!-- Affichage du message d'erreur si existant -->
            <?php if (isset($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </section>
    </main>

     <!-- Footer -->
    <footer>
        <p> © Livre d'or - Tous droits réservés.</p>
    </footer>
</body>

</html>
