<?php
session_start();
include "config/serveur.php";
$id = $_SESSION['id'];
if (!isset($id)) {
    header("location: index.php");
    exit();
}

//  formulaire soumis
if (isset($_POST['envoyer'])) {
    // Sécurisation  
    $comm = $bdd->real_escape_string($_POST['comm']);
    // enregistrement 
    $date = date('Y-m-d H:i:s');

    //  prépare une
    $stmt = $bdd->prepare("INSERT INTO commentaires (commentaire, id_utilisateurs, date) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $comm, $id, $date);

    // requête et gestion du message de succès ou d'erreur
    if ($stmt->execute()) {
        $message = "Commentaire ajouté avec succès !";
    } else {
        $erreur = "Erreur lors de l'ajout du commentaire : " . $bdd->error;
    }
}

// Limite de session : 30 minutes (1800 secondes)

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
