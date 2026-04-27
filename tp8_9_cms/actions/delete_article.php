<?php
/*
 * FICHIER : actions/delete_article.php
 * RÔLE : Script de suppression d'un article (sans interface HTML).
 * Vérifie les droits Admin, supprime l'article via requête préparée (sécurisée),
 * puis redirige vers le tableau de bord Admin.
 * (Partie 3 & 4 du TP9 : CRUD + Sécurisation avec requêtes préparées)
 */

// 1. Démarrage de la session
if (session_status() === PHP_SESSION_NONE) session_start();

// 2. Vérification des droits : Seul l'Admin peut supprimer un article (Partie 5 TP9)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Action interdite : l'utilisateur n'est pas admin
    die("Action interdite"); // Message d'erreur explicite (comme demandé dans TP9)
}

// 3. Importation de la connexion BDD
require_once '../config/db.php';

// 4. Vérification de la présence de l'ID dans l'URL (?id=...)
if (isset($_GET['id'])) {
    // Sécurité : On convertit l'ID en entier (Int) pour éviter les injections SQL
    $id = (int) $_GET['id'];

    // 5. Requête préparée pour supprimer l'article (Partie 4 TP9 : Protection SQL Injection)
    // Remplacement de : $conn->query("DELETE FROM articles WHERE id=$id")  [DANGEREUX]
    // Par une requête préparée avec paramètre lié                          [SÉCURISÉ ✅]
    $stmt = $conn->prepare("DELETE FROM articles WHERE id=?");
    $stmt->bind_param("i", $id); // 'i' = Integer
    $stmt->execute();
    $stmt->close(); // Bonne pratique : fermer la requête après exécution
}

// 6. Redirection vers le Dashboard Admin après la suppression
header("Location: ../admin/dashboard.php");
exit();
?>
