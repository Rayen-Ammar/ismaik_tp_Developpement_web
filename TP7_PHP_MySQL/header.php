<?php
/*
 * Fichier: header.php
 * Description: Ce fichier contient l'en-tête HTML commun à toutes les pages de l'application,
 *              ainsi que la barre de navigation. Il assure une apparence cohérente et facilite
 *              la navigation entre les différentes sections (Accueil, Étudiants, Notes, Statistiques).
 *              Le design a été amélioré pour être plus moderne et professionnel.
 * Auteur: [Ammar Rayen]
 */

// Démarrage de la session si ce n'est pas déjà fait. Utile pour la gestion de l'authentification.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté. Si non, redirige vers la page de connexion.
// Ceci est une sécurité de base pour protéger les pages de l'application.
// Les pages 'login.php' et 'verification.php' sont exemptées de cette vérification.
if (!isset($_SESSION['username']) && basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'verification.php') {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP7 - Application de Gestion</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Styles généraux pour l'ensemble de l'application */
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-bg: #f8f9fa;
            --white-bg: #ffffff;
            --border-color: #dee2e6;
            --shadow-color: rgba(0,0,0,.05);
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: var(--light-bg);
            color: #343a40;
            line-height: 1.6;
        }
        .navbar {
            background-color: var(--primary-color);
            padding: 15px 25px;
            color: var(--white-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 8px var(--shadow-color);
        }
        .navbar a {
            color: var(--white-bg);
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 400;
        }
        .navbar a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .navbar .logo {
            font-size: 1.8em;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .navbar .nav-links {
            display: flex;
            gap: 10px;
        }
        .container {
            padding: 30px;
            max-width: 1200px;
            margin: 30px auto;
            background-color: var(--white-bg);
            border-radius: 10px;
            box-shadow: 0 5px 20px var(--shadow-color);
        }
        h1, h2, h3 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 700;
            text-align: center;
        }
        h2 {
            font-size: 1.8em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            border-radius: 8px;
            overflow: hidden; /* Ensures rounded corners apply to inner elements */
        }
        table, th, td {
            border: 1px solid var(--border-color);
        }
        th, td {
            padding: 15px 20px;
            text-align: left;
        }
        th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2f0ff; /* Light blue hover effect */
        }
        form {
            background-color: var(--light-bg);
            padding: 30px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            margin-top: 25px;
            box-shadow: 0 2px 10px var(--shadow-color);
        }
        form label {
            display: block;
            margin-bottom: 10px;
            font-weight: 700;
            color: #343a40;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: calc(100% - 24px); /* Adjust for padding and border */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        form input[type="submit"] {
            background-color: var(--success-color);
            color: var(--white-bg);
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 700;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }
        form input[type="submit"]:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .logout-btn {
            background-color: var(--danger-color);
            color: var(--white-bg);
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 400;
        }
        .logout-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: var(--light-bg);
            margin-bottom: 10px;
            padding: 15px;
            border-left: 5px solid var(--primary-color);
            border-radius: 5px;
            box-shadow: 0 1px 5px var(--shadow-color);
        }
        ul li b {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo"><a href="index.php">TP7 App</a></div>
        <div class="nav-links">
            <?php if (isset($_SESSION['username'])): ?>
                <a href="index.php?page=ajouter_etudiant">Ajouter Étudiant</a>
                <a href="index.php?page=afficher_etudiants">Liste Étudiants</a>
                <a href="index.php?page=moyenne_etudiant">Moyenne Étudiants</a>
                <a href="index.php?page=meilleure_note">Meilleure Note</a>
                <a href="index.php?page=securisation_real_escape">Sécurité (Demo)</a>
                <a href="logout.php" class="logout-btn">Déconnexion (<?php echo $_SESSION['username']; ?>)</a>
            <?php else: ?>
                <a href="login.php">Connexion</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
