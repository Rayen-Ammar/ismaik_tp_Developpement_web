<?php
/*
 * FICHIER : actions/add_comment.php
 * RÔLE : Script invisible de traitement. Il ne contient pas de HTML.
 * Il s'occupe de recevoir les données du formulaire de commentaire, de les sécuriser,
 * de les insérer dans la base de données, puis de rediriger l'utilisateur vers l'article.
 */

// 1. Initialisation de la session (nécessaire pour vérifier si l'utilisateur est connecté)
session_start();

// Inclusion de la connexion à la BDD
require_once dirname(__DIR__) . '/config/db.php';

// 2. Vérification d'accès : 
// - La page a-t-elle été appelée via une méthode POST ?
// - L'utilisateur est-il bien identifié dans la session ?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    
    // Récupération et nettoyage du texte envoyé
    $content = trim($_POST['content']);
    $article_id = (int)$_POST['article_id']; // Forcé en 'Entier' par sécurité
    $user_id = (int)$_SESSION['user_id'];
    
    // Si le commentaire n'est pas vide (après suppression des espaces invisibles)
    if(!empty($content)) {
        // Préparation de l'insertion dans la table comments
        $stmt = $conn->prepare("INSERT INTO comments (content, article_id, user_id) VALUES (?, ?, ?)");
        // 'sii' = String, Integer, Integer
        $stmt->bind_param("sii", $content, $article_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // 3. Redirection rapide vers l'article pour que l'utilisateur voie son commentaire apparaître
    header("Location: ../frontend/article.php?id=" . $article_id);
    exit; // Fin du script
    
} else {
    // Si on a tapé l'URL add_comment.php directement sans se connecter, on est renvoyé au Login
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}
