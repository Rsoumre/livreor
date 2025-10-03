<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de connexion à la base de données
require_once 'config/serveur.php';

// Vérification que l'utilisateur est connecté, sinon redirection
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupération de l'ID de l'utilisateur connecté
$id = $_SESSION['id'];

// Gestion de la limite de session (30 minutes)
$session_timeout = 1800;
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout) {
        // Si inactif trop longtemps, destruction de session et redirection
        session_unset();
        session_destroy();
        header('Location: connexion.php?timeout=1');
        exit();
    }
}
// Mise à jour du timestamp de la dernière activité
$_SESSION['LAST_ACTIVITY'] = time();

// Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et sécurisation des données
    $login = $bdd->real_escape_string($_POST['login']);
    $prenom = $bdd->real_escape_string($_POST['prenom']);
    $nom = $bdd->real_escape_string($_POST['nom']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Préparation pour la mise à jour du mot de passe
    $password_update = '';
    if (!empty($password)) {
        if ($password !== $confirm_password) {
            $error = "Les mots de passe ne correspondent pas";
        } else {
            // Hashage du nouveau mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $password_update = ", password = '$hashed_password'";
        }
    }

    // Mise à jour des informations si pas d'erreur
    if (empty($error)) {
        $query = "UPDATE utilisateurs SET 
                 login = '$login', 
                 prenom = '$prenom', 
                 nom = '$nom'
                 $password_update
                 WHERE id = $id";

        if ($bdd->query($query)) {
            // Mise à jour des variables de session
            $_SESSION['login'] = $login;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['nom'] = $nom;
            $message = "Profil mis à jour avec succès !";
        } else {
            $error = "Erreur lors de la mise à jour : " . $bdd->error;
        }
    }
}

// Requête pour récupérer les informations actuelles de l'utilisateur
$result = $bdd->query("SELECT * FROM utilisateurs WHERE id = $id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <title>Profil</title>
    <link href="style.css" rel="stylesheet" />

</head>

<body>

    <?php include 'layout/header.php'; ?>


    <h1>Modifier mon profil</h1>

    <?php if (!empty($message)): ?>
        <p class="success"><?= $message ?></p>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nom:</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Prénom:</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Login:</label>
            <input type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nouveau mot de passe (laisser vide pour ne pas changer):</label>
            <input type="password" name="password">
        </div>
        <div class="form-group">
            <label>Confirmer le nouveau mot de passe:</label>
            <input type="password" name="confirm_password">
        </div>
        <button type="submit">Enregistrer</button>
    </form>
    <br>
    <br>
     <!-- Footer -->
    <footer>
        <p> © Livre d'or - Tous droits réservés.</p>
    </footer>
</body>

</html>