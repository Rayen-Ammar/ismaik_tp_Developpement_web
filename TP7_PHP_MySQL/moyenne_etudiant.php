<?php
/*
 * Fichier: moyenne_etudiant.php
 * Description: Ce script PHP calcule et affiche la moyenne des notes pour chaque étudiant.
 *              Il se connecte à la base de données, regroupe les notes par étudiant et calcule
 *              la moyenne pour chaque groupe. Les résultats sont présentés dans un tableau HTML.
 *              Ce fichier est maintenant intégré dans l\"application via index.php.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

// Requête SQL pour calculer la moyenne des notes par étudiant.
// JOIN est utilisé pour lier les tables \"etudiants\" et \"notes\" sur \"id_etudiant\".
// AVG(n.note) calcule la moyenne des notes.
// GROUP BY e.id, e.nom, e.prenom regroupe les résultats par étudiant.
$sql = "SELECT e.id, e.nom, e.prenom, AVG(n.note) AS moyenne_notes 
        FROM etudiants e 
        JOIN notes n ON e.id = n.id_etudiant 
        GROUP BY e.id, e.nom, e.prenom";
$result = $conn->query($sql);

?>

        <h2>Moyenne des Notes par Étudiant</h2>

        <?php
        // Vérifie si des résultats ont été retournés par la requête.
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>ID Étudiant</th><th>Nom</th><th>Prénom</th><th>Moyenne</th></tr></thead>";
            echo "<tbody>";
            // Parcourt chaque ligne de résultat et affiche les données.
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nom"]. "</td><td>" . $row["prenom"]. "</td><td>" . round($row["moyenne_notes"], 2). "</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            // Si aucune moyenne n\"est trouvée (par exemple, aucun étudiant avec des notes).
            echo "<p class=\'alert-info\'>Aucune moyenne trouvée pour les étudiants.</p>";
        }
        // Fermeture de la connexion à la base de données.
        $conn->close();
        ?>
