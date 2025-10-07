<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'livreor');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

// Configuration générale de l'application
define('BASE_URL', 'http://localhost/livreor/');
define('APP_NAME', 'PHP MVC Starter');
define('APP_VERSION', '1.0.0');

// Configuration des chemins
define('ROOT_PATH', dirname(__DIR__));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers');
define('MODEL_PATH', ROOT_PATH . '/models');
define('VIEW_PATH', ROOT_PATH . '/views');
define('INCLUDE_PATH', ROOT_PATH . '/includes');
define('CORE_PATH', ROOT_PATH . '/core');
define('PUBLIC_PATH', ROOT_PATH . '/public');


try {
    $bdd = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $bdd->set_charset(DB_CHARSET);

    if ($bdd->connect_error) {
        die('Erreur de connexion à la base de données : ' . $bdd->connect_error);
    }
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
