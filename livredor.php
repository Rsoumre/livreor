<?php
session_start();
include 'config/serveur.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/livre-or.css">
</head>

<body class="fond4">
    <!-- Inclusion du header commun à toutes les pages (navigation/menu) -->
    <?php include 'layout/header.php'; ?>

    <main>
        <div class="parent">
            <div class="text">
                <h2>Livre d'or</h2>
                <table class="accueil-table-text">
                    <thead>
                        <tr>
                            <th>Pseudo</th> <!-- Nom d'utilisateur -->
                            <th>Commentaires</th> <!-- Contenu du commentaire -->
                            <th>Date et Heure</th> <!-- Date et heure du commentaire -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Requête SQL pour récupérer tous les commentaires avec le login de l'utilisateur
                        $req = mysqli_query($bdd, "SELECT commentaires.*, utilisateurs.login 
                                                   FROM commentaires 
                                                   INNER JOIN utilisateurs ON utilisateurs.id = commentaires.id_utilisateurs 
                                                   ORDER BY commentaires.date DESC");

                        // Transformation du résultat en tableau associatif
                        $reponse = mysqli_fetch_all($req, MYSQLI_ASSOC);

                        // Boucle sur chaque commentaire pour l'afficher dans le tableau
                        foreach ($reponse as $comm) :
                        ?>
                            <tr>
                                <!-- Affichage sécurisé du login de l'utilisateur -->
                                <td><?= htmlspecialchars($comm['login']) ?></td>
                                <!-- Affichage sécurisé du texte du commentaire -->
                                <td><?= htmlspecialchars($comm['commentaire']) ?></td>
                                <!-- Affichage sécurisé de la date et heure du commentaire -->
                                <td><?= htmlspecialchars($comm['date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

     <!-- Footer -->
    <footer>
        <p> © Livre d'or - Tous droits réservés.</p>
    </footer>
</body>

</html>
