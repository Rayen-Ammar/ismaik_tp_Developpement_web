<?php
/*
 * FICHIER : auth/logout.php
 * RÔLE : Déconnecter l'utilisateur courant.
 * Ce script détruit la session active et redirige l'utilisateur vers la page de connexion.
 */

// 1. On démarre (ou récupère) la session courante pour pouvoir la manipuler
session_start();

// 2. On vide toutes les variables de session ($_SESSION)
session_unset();

// 3. On détruit physiquement la session côté serveur
session_destroy();

// On inclut db.php uniquement pour récupérer la constante BASE_URL servant à la redirection
require_once dirname(__DIR__) . '/config/db.php';

// 4. Redirection vers la page de login
header("Location: " . BASE_URL . "/auth/login.php");
exit(); // Arrêt de l'exécution pour être sûr que la redirection s'applique
?>
