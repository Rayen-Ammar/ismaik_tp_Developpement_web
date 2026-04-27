<?php
/**
 * ==========================================================
 * FICHIER DE CONFIGURATION DE LA BASE DE DONNÉES
 * Projet : Gestion des Étudiants (TP6)
 * ==========================================================
 */

// Définition des paramètres de connexion à la base de données
// Ces paramètres sont les valeurs par défaut pour une installation XAMPP standard
$host = "localhost";            // Adresse du serveur de base de données (généralement localhost)
$user = "root";                 // Nom d'utilisateur MySQL par défaut sur XAMPP
$password = "";                 // Mot de passe MySQL par défaut sur XAMPP (vide)
$db = "gestion_etudiants";      // Nom de la base de données spécifié dans le TP6

// Tentative de connexion au serveur MySQL en utilisant l'extension mysqli
// On crée une nouvelle instance de l'objet mysqli avec les paramètres définis ci-dessus
$conn = new mysqli($host, $user, $password, $db);

// Vérification de l'état de la connexion
// Si la connexion échoue, on arrête l'exécution du script et on affiche l'erreur
if ($conn->connect_error) {
    // La fonction die() affiche un message et termine le script actuel
    die("Erreur de connexion : " . $conn->connect_error);
}

// Définition du jeu de caractères en UTF-8 pour éviter les problèmes d'accents
$conn->set_charset("utf8mb4");

// Si nous arrivons ici, la connexion est établie avec succès
?>
