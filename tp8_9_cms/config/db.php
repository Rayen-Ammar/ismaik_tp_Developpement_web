<?php
/*
 * FICHIER : config/db.php
 * RÔLE : Etablir la connexion avec la base de données MySQL et définir les constantes globales.
 * Ce fichier est inclus (avec require_once) au début de pratiquement toutes les pages pour garantir
 * que l'application peut toujours communiquer avec la base de données.
 */

// Définition de la racine du site, utile pour créer des liens absolus vers les assets (CSS, JS, images).
define('BASE_URL', '/tp8_cms');

// Création d'une nouvelle instance de la classe mysqli pour se connecter à MySQL.
// Paramètres : ('serveur', 'nom_utilisateur', 'mot_de_passe', 'nom_base_de_donnees')
$conn = new mysqli("localhost", "root", "", "tp8_cms");

// Vérification de la connexion : si une erreur survient (ex: mauvais mot de passe ou base inexistante),
if ($conn->connect_error) {
    // on arrête l'exécution immédiatemment (die) et on affiche un message d'erreur.
    die("Erreur connexion");
}
?>