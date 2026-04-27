<?php
/*
 * Fichier: ajouter_etudiant.php
 * Description: Ce script PHP permet d'ajouter un nouvel étudiant à la base de données.
 *              Il affiche un formulaire HTML pour la saisie du nom, prénom et email de l'étudiant.
 *              Lors de la soumission du formulaire, les données sont validées et insérées
 *              dans la table 'etudiants' de la base de données 'tp7'.
 *              Ce fichier est maintenant intégré dans l'application via index.php.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

$message = ''; // Variable pour stocker les messages de succès ou d'erreur.

// Vérifie si le formulaire a été soumis (méthode POST).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire.
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $email = htmlspecialchars(trim($_POST["email"]));

    // Validation simple des données.
    if (empty($nom) || empty($prenom) || empty($email)) {
        $message = '<p class="alert-danger">Veuillez remplir tous les champs.</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="alert-danger">Format d\'email invalide.</p>';
    } else {
        // Préparation de la requête SQL pour insérer un nouvel étudiant.
        // Utilisation de requêtes préparées pour éviter les injections SQL.
        $stmt = $conn->prepare("INSERT INTO etudiants (nom, prenom, email) VALUES (?, ?, ?)");
        // Liaison des paramètres (s = string) et exécution de la requête.
        $stmt->bind_param("sss", $nom, $prenom, $email);

        if ($stmt->execute()) {
            $message = '<p class="alert-success">Nouvel étudiant ajouté avec succès.</p>';
        } else {
            $message = '<p class="alert-danger">Erreur lors de l\'ajout de l\'étudiant: ' . $stmt->error . '</p>';
        }

        // Fermeture de la requête préparée.
        $stmt->close();
    }
}

// Fermeture de la connexion à la base de données (si elle n'est pas déjà fermée par db_config.php).
// Dans ce cas, db_config.php ne ferme pas la connexion, donc on la ferme ici.
$conn->close();
?>

        <h2>Ajouter un nouvel étudiant</h2>

        <?php echo $message; // Affiche les messages de succès ou d'erreur ?>

        <form action="index.php?page=ajouter_etudiant" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Ajouter l'étudiant">
        </form>
