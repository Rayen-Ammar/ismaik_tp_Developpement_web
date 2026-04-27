<?php
/*
 * Fichier: afficher_etudiants.php
 * Description: Ce script PHP se connecte à la base de données et affiche la liste de tous les étudiants
 *              enregistrés dans la table 'etudiants'. Les informations affichées incluent l'ID,
 *              le nom, le prénom et l'email de chaque étudiant.
 *              Ce fichier est maintenant intégré dans l'application via index.php.
 * Auteur: [Votre Nom]
 * Date: 11 avril 2026
 */

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

// Requête SQL pour sélectionner tous les étudiants de la table 'etudiants'.
$sql = "SELECT id, nom, prenom, email FROM etudiants";
$result = $conn->query($sql);

?>

        <h2>Liste des Étudiants</h2>

        <?php
        // Vérifie si des résultats ont été retournés par la requête.
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr></thead>";
            echo "<tbody>";
            // Parcourt chaque ligne de résultat et affiche les données de l'étudiant.
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nom"]. "</td><td>" . $row["prenom"]. "</td><td>" . $row["email"]. "</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            // Si aucune étudiant n'est trouvé dans la base de données.
            echo "<p class='alert-info'>Aucun étudiant trouvé.</p>";
        }
        // Fermeture de la connexion à la base de données.
        $conn->close();
        ?>
