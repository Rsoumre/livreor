<?php
// Démarrage de la session pour gérer la connexion utilisateur
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
include 'config/serveur.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <!-- Compatibilité avec Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <!-- Adaptation pour les écrans mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Livre d'or</title>

    <!-- Feuilles de style principales -->
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/livre-or.css">
</head>

<body class="fond4">
    <!-- Inclusion du header commun à toutes les pages (navigation/menu) -->
    <?php include 'layout/header.php'; ?>

    <main>
        <!-- Conteneur principal centré et avec image de fond -->
        <div class="parent">
            <!-- Conteneur du texte et du tableau avec fond semi-transparent -->
            <div class="text">
                <!-- Titre de la page -->
                <h2>Livre d'or</h2>

                <!-- Tableau affichant les commentaires -->
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
