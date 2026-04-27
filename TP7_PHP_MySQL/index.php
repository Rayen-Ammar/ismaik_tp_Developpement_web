<?php
/*
 * Fichier: index.php
 * Description: Ce fichier est le point d'entrée principal de l'application. Il inclut l'en-tête (header.php)
 *              qui gère la navigation et l'authentification. Il charge dynamiquement le contenu des
 *              différentes pages (ajouter_etudiant, afficher_etudiants, etc.) en fonction du paramètre 'page'
 *              passé dans l'URL. Si aucun paramètre 'page' n'est spécifié, il affiche une page d'accueil par défaut.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier d'en-tête qui contient le début du HTML, la barre de navigation et la logique d'authentification.
include_once 'header.php';

// Récupère le paramètre 'page' de l'URL. Si non défini, utilise 'home' par défaut.
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Vérifie si l'utilisateur est connecté pour afficher le contenu.
// La page de connexion et de vérification sont accessibles sans être connecté.
if (!isset($_SESSION['username']) && $page != 'home') {
    // Si l'utilisateur n'est pas connecté et tente d'accéder à une page protégée,
    // il est redirigé vers la page de connexion via la logique dans header.php.
    // Pour éviter une double redirection, on ne fait rien ici si header.php a déjà géré la redirection.
    // On peut aussi afficher un message d'erreur ou un contenu par défaut.
    echo "<p class='alert-danger'>Vous devez être connecté pour accéder à cette section.</p>";
} else {
    // Affiche le contenu de la page demandée.
    switch ($page) {
        case 'home':
            echo "<h1>Bienvenue sur l'Application de Gestion TP7</h1>";
            echo "<p>Utilisez le menu de navigation ci-dessus pour accéder aux différentes fonctionnalités :</p>";
            echo "<ul>";
            echo "<li><b>Ajouter Étudiant</b> : Pour enregistrer de nouveaux étudiants.</li>";
            echo "<li><b>Liste Étudiants</b> : Pour visualiser tous les étudiants inscrits.</li>";
            echo "<li><b>Moyenne Étudiants</b> : Pour consulter la moyenne des notes par étudiant.</li>";
            echo "<li><b>Meilleure Note</b> : Pour trouver la note la plus élevée.</li>";
            echo "<li><b>Sécurité (Demo)</b> : Pour une démonstration de la sécurisation des entrées.</li>";
            echo "</ul>";
            echo "<p>Veuillez vous connecter pour accéder à toutes les fonctionnalités.</p>";
            break;
        case 'ajouter_etudiant':
            include 'ajouter_etudiant.php';
            break;
        case 'afficher_etudiants':
            include 'afficher_etudiants.php';
            break;
        case 'moyenne_etudiant':
            include 'moyenne_etudiant.php';
            break;
        case 'meilleure_note':
            include 'meilleure_note.php';
            break;
        case 'securisation_real_escape':
            include 'securisation_real_escape.php';
            break;
        default:
            echo "<h1>Page non trouvée</h1>";
            echo "<p>La page que vous avez demandée n'existe pas.</p>";
            break;
    }
}

// Inclut le fichier de pied de page (footer.php) qui contient la fin du HTML.
include_once 'footer.php';
?>
