<?php
/*
 * Fichier: db_config.php
 * Description: Ce fichier centralise les paramètres de connexion à la base de données MySQL.
 *              Il est inclus par tous les scripts PHP qui nécessitent une interaction avec la base de données.
 *              Cela permet une gestion plus facile des informations de connexion et évite la répétition du code.
 * Auteur: [Ammar Rayen]
 */

// Paramètres de connexion à la base de données.
// Assurez-vous que ces informations correspondent à votre configuration MySQL (XAMPP, WAMP, etc.).
$servername = "localhost"; // L'adresse du serveur de base de données (souvent 'localhost').
$username_db = "root";    // Le nom d'utilisateur pour se connecter à la base de données (par défaut 'root' pour XAMPP).
$password_db = "";        // Le mot de passe pour se connecter à la base de données (vide par défaut pour XAMPP).
$dbname = "tp7";          // Le nom de la base de données que nous avons créée ('tp7').

// Création d'une nouvelle connexion à la base de données en utilisant l'extension MySQLi.
// L'objet $conn sera utilisé pour toutes les interactions avec la base de données.
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Vérification de la connexion.
// Si la connexion échoue, un message d'erreur est affiché et le script est arrêté (die()).
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données: " . $conn->connect_error);
}

// Définir l'encodage des caractères pour la connexion à la base de données.
// Cela garantit que les caractères spéciaux (comme les accents) sont correctement gérés.
$conn->set_charset("utf8");

?>
