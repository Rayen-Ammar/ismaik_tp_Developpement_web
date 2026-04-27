<?php
/*
 * Fichier: verification.php
 * Description: Ce script PHP est responsable de la vérification des identifiants de connexion
 *              soumis via le formulaire de login (login.php). Il se connecte à la base de données,
 *              récupère les informations de l\"utilisateur et compare le nom d\"utilisateur et le mot de passe.
 *              En cas de succès, il redirige vers la page d\"accueil; sinon, il affiche un message d\"erreur.
 * Auteur: [Ammar Rayen]
 */

// Démarrage de la session pour pouvoir stocker des variables de session (par exemple, l\"utilisateur connecté).
session_start();

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

// Vérifie si le formulaire a été soumis.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données soumises par le formulaire via la méthode POST.
    // Les fonctions htmlspecialchars() et trim() sont utilisées pour sécuriser et nettoyer les entrées.
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Préparation de la requête SQL pour sélectionner l\"utilisateur.
    // Nous utilisons une requête préparée pour prévenir les injections SQL, une bonne pratique de sécurité.
    $stmt = $conn->prepare("SELECT id, username, password FROM utilisateurs WHERE username = ? AND password = ?");

    // Liaison des paramètres à la requête préparée.
    // \"ss\" indique que les deux paramètres sont des chaînes de caractères (string).
    $stmt->bind_param("ss", $username, $password);

    // Exécution de la requête préparée.
    $stmt->execute();

    // Récupération du résultat de la requête.
    $result = $stmt->get_result();

    // Vérification si un utilisateur correspondant a été trouvé.
    if ($result->num_rows > 0) {
        // Si un utilisateur est trouvé, la connexion est réussie.
        // On stocke le nom d\"utilisateur dans la session.
        $_SESSION['username'] = $username;
        // Redirection vers la page d\"accueil après une connexion réussie.
        header("Location: index.php");
        exit();
    } else {
        // Si aucun utilisateur n\"est trouvé, la connexion échoue.
        // On redirige vers la page de connexion avec un message d\"erreur.
        $_SESSION['login_error'] = "Nom d\"utilisateur ou mot de passe incorrect.";
        header("Location: login.php");
        exit();
    }

    // Fermeture de la requête préparée.
    $stmt->close();
}

// Fermeture de la connexion à la base de données.
$conn->close();

// Si le script est accédé directement sans soumission de formulaire, rediriger vers la page de connexion.
header("Location: login.php");
exit();

?>
