<?php
/*
 * FICHIER : includes/header.php
 * RÔLE : En-tête global de toutes les pages (HTML standard, import SEO/Assets, Barre de navigation).
 * Gère également l'affichage conditionnel des boutons de la barre de navigation selon si
 * l'utilisateur est connecté, déconnecté, ou s'il est administrateur.
 */

// Si la session n'est pas encore démarrée, on la démarre pour pouvoir accéder à $_SESSION
if(session_status() === PHP_SESSION_NONE) session_start();

// Inclusion de la connexion à la base de données (chemin absolu pour éviter les erreurs d'inclusion)
require_once dirname(__DIR__) . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexGen CMS</title>
    <!-- Polices Google modernes (Outfit pour les titres, Inter pour le corps du texte) -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Icônes élégantes FontAwesome pour habiller les boutons et les menus -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fichier CSS principal de l'application -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
<!-- Barre de navigation (navbar) avec un style graphique 'glass' (translucide) -->
<nav class="navbar glass">
    <div class="nav-container">
        <!-- Logo et nom du site qui renvoient vers la page d'accueil -->
        <a href="<?= BASE_URL ?>/frontend/index.php" class="nav-brand">
            <i class="fa-solid fa-layer-group"></i> NexGen<span>CMS</span>
        </a>
        
        <div class="nav-menu">
            <!-- Lien vers l'accueil public -->
            <a href="<?= BASE_URL ?>/frontend/index.php" class="nav-link"><i class="fa-solid fa-house"></i> Accueil</a>
            
            <?php if(isset($_SESSION['user_id'])): // Si l'utilisateur est connecté ?>
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): // S'il a le rôle admin ?>
                    <!-- Lien Admin : accès au panneau d'administration complet -->
                    <a href="<?= BASE_URL ?>/admin/dashboard.php" class="nav-link"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'user'): // Utilisateur simple (Partie 5 TP9) ?>
                    <!-- Lien User : espace personnel (lecture + commentaires uniquement) -->
                    <a href="<?= BASE_URL ?>/frontend/user_dashboard.php" class="nav-link"><i class="fa-solid fa-circle-user"></i> Mon Espace</a>
                <?php endif; ?>
                
                <!-- Badge montrant le nom de l'utilisateur connecté -->
                <div class="user-badge">
                    <div class="avatar"><i class="fa-solid fa-user"></i></div>
                    <span><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                </div>
                
                <!-- Bouton de déconnexion -->
                <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
                
            <?php else: // Si l'utilisateur est un visiteur (non connecté) ?>
                <!-- On lui propose de se connecter ou de créer un compte -->
                <a href="<?= BASE_URL ?>/auth/login.php" class="btn btn-outline"><i class="fa-solid fa-user"></i> Connexion</a>
                <a href="<?= BASE_URL ?>/auth/register.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> S'inscrire</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Divs gérant les grandes formes d'arrière-plan coloré (Animations Glassmorphism) -->
<div class="page-background">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
</div>

<!-- Lancement du conteneur principal de la page (il sera fermé dans footer.php) -->
<main class="main-content">
