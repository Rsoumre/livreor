<?php
// Démarrage de la session pour gérer les utilisateurs connectés
session_start();

// Inclusion du fichier de connexion à la base de données
include "config/serveur.php";

// Récupération de l'ID de l'utilisateur connecté
$id = $_SESSION['id'];

// Vérification que l'utilisateur est bien connecté
if (!isset($id)) {
    // Si pas connecté, redirection vers la page d'accueil
    header("location: index.php");
    exit();
}

// Vérification si le formulaire a été soumis
if (isset($_POST['envoyer'])) {
    // Sécurisation du commentaire pour éviter les injections SQL
    $comm = $bdd->real_escape_string($_POST['comm']);
    // Récupération de la date et heure actuelles
    $date = date('Y-m-d H:i:s');

    // Préparation de la requête pour insérer le commentaire dans la base
    $stmt = $bdd->prepare("INSERT INTO commentaires (commentaire, id_utilisateurs, date) VALUES (?, ?, ?)");
    // Liaison des paramètres à la requête préparée : s = string, i = integer
    $stmt->bind_param("sis", $comm, $id, $date);

    // Exécution de la requête et gestion du message de succès ou d'erreur
    if ($stmt->execute()) {
        $message = "Commentaire ajouté avec succès !";
    } else {
        $erreur = "Erreur lors de l'ajout du commentaire : " . $bdd->error;
    }
}

// Limite de session : 30 minutes (1800 secondes)
// Cette partie détruit la session si inactivité prolongée
$session_timeout = 1800;
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout) {
        // Suppression des données de session et redirection
        session_unset();
        session_destroy();
        header('Location: connexion.php?timeout=1');
        exit();
    }
}
// Mise à jour du timestamp de la dernière activité
$_SESSION['LAST_ACTIVITY'] = time();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Commentaires</title>

    <!-- Feuilles de style pour le site et la page commentaires -->
    <link rel="stylesheet" href="assets/css/commentaire.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body class="fond5">
    <!-- Inclusion du menu/navigation -->
    <?php include 'layout/header.php'; ?>

    <main class="main-wrap">
        <h2>Espace Commentaires</h2>

        <section class="comment-container">
            <!-- Formulaire pour envoyer un commentaire -->
            <form action="commentaire.php" method="post" class="comment-form">
                <label for="commentaire" class="comment-label">Laisser un commentaire :</label>
                <textarea name="comm" id="commentaire" rows="6" required></textarea>
                <div class="btn-row">
                    <button type="submit" name="envoyer" class="btn-envoyer">Envoyer</button>
                </div>
            </form>

            <!-- Affichage des messages de succès ou d'erreur -->
            <?php if (isset($message)) : ?>
                <p class="message success"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
            <?php if (isset($erreur)) : ?>
                <p class="message error"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer du site -->
    <footer>
        <div class="copy">
            Livre d'or © Tous droits réservés.
        </div>
    </footer>
</body>

</html>
