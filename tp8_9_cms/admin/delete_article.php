<?php
/*
 * FICHIER : admin/delete_article.php
 * RÔLE : Script silencieux (sans interface) permettant à l'administrateur de supprimer un article.
 * Ce script s'assure que seul un Admin peut l'exécuter, récupère l'ID, supprime la ligne
 * dans la table MySQL, puis retourne instantanément au tableau de bord.
 */

// 1. Initialisation de la session
if(session_status() === PHP_SESSION_NONE) session_start();

// 2. Vérification stricte des permissions (Seulement l'Admin a le droit)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Si l'utilisateur n'est pas admin, il est expulsé vers l'accueil
    header("Location: ../frontend/index.php");
    exit();
}

// 3. Importation de la base de données
require_once '../config/db.php';

// 4. Si l'URL contient bien le paramètre '?id=' (l'ID de l'article à supprimer)
if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Cast forcé en entier pour sécuriser l'ID
    
    // Vérification de sécurité : Suppression en base de données de l'article correspondant
    // Note : Si des commentaires sont liés à cet article, ils seront automatiquement supprimés
    // grâce à la règle "ON DELETE CASCADE" définie lors de la création de la table SQL.
    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' = Integer
    $stmt->execute();
    $stmt->close();
}

// 5. Quoi qu'il arrive, on retourne immédiatement au point de départ : le Dashboard
header("Location: dashboard.php");
exit();
?>
