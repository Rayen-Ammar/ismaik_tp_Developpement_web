<?php
/*
 * Fichier: logout.php
 * Description: Ce script PHP gère la déconnexion de l'utilisateur.
 *              Il détruit la session en cours et redirige l'utilisateur vers la page de connexion (login.php).
 * Auteur: [Ammar Rayen]
 */

// Démarrage de la session si ce n'est pas déjà fait.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Détruit toutes les variables de session.
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), 
              '', 
              time() - 42000, 
              $params["path"],
              $params["domain"],
              $params["secure"],
              $params["httponly"]
    );
}

// Finalement, détruit la session.
session_destroy();

// Redirige l'utilisateur vers la page de connexion.
header("Location: login.php");
exit();
?>
