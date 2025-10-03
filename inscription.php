<?php
// Démarrage de la session pour gérer l'utilisateur connecté
session_start();

// Durée maximale de la session : 30 minutes (1800 secondes)
$session_timeout = 1800;

// Vérification de la dernière activité de l'utilisateur
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout) {
        // Si la session a expiré, on la détruit et redirige vers la page de connexion
        session_unset();
        session_destroy();
        header('Location: connexion.php?timeout=1');
        exit();
    }
}
// Mise à jour du timestamp de la dernière activité
$_SESSION['LAST_ACTIVITY'] = time();

// Inclusion du fichier de connexion à la base de données
include "config/serveur.php";

// Variable pour stocker les messages d'erreur
$error = null;

// Si l'utilisateur est déjà connecté, redirection vers le profil
if (isset($_SESSION['id'])) {
    header('Location: profil.php');
    exit();
}

// Traitement du formulaire après soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sécurisation des entrées utilisateurs pour éviter les injections SQL
    $login = $bdd->real_escape_string($_POST['login']);
    $prenom = $bdd->real_escape_string($_POST['prenom']);
    $nom = $bdd->real_escape_string($_POST['nom']);
    $password = $_POST['password'];
    $confirm = $_POST['password_re'];

    // Vérification que les deux mots de passe correspondent
    if ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        // Hashage sécurisé du mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Requête préparée pour insérer l'utilisateur dans la base de données
        $stmt = $bdd->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $login, $prenom, $nom, $hash);

        // Exécution de la requête et redirection vers la connexion si succès
        if ($stmt->execute()) {
            header('Location: connexion.php');
            exit();
        } else {
            // Message d'erreur si l'insertion échoue
            $error = "Erreur lors de l'inscription : " . $bdd->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Polices Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/inscription.css">

    <title>Inscription - Livre d'or</title>
</head>

<body class="fond1">
    <!-- Inclusion du header -->
    <?php include 'layout/header.php'; ?>

    <main>
        <!-- Titre de la page -->
        <h2>Formulaire d'inscription</h2>

        <!-- Container pour centrer le formulaire -->
        <section class="incueil">

            <!-- Formulaire d'inscription -->
            <form action="inscription.php" method="post" class="form-card">

                <!-- Nom -->
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" placeholder="Nom" required>
                </div>

                <!-- Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                </div>

                <!-- Login -->
                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" name="login" placeholder="Login" required>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="form-group">
                    <label for="password_re">Confirmation :</label>
                    <input type="password" name="password_re" placeholder="Confirmer mot de passe" required>
                </div>

                <!-- Bouton de soumission -->
                <input type="submit" value="S'inscrire" name="valider" class="btn btn-primary">
            </form>

            <!-- Affichage des erreurs si elles existent -->
            <?php if ($error): ?>
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
