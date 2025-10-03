<?php
// Démarre une session pour pouvoir accéder aux variables de session
session_start();

// Détruit toutes les données de la session en cours (déconnexion)
session_destroy();

// Redirige l'utilisateur vers la page de connexion après la déconnexion
header("Location: connexion.php"); 
?>
