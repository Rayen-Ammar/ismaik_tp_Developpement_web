<?php
/*
 * Fichier: meilleure_note.php
 * Description: Ce script PHP se connecte à la base de données pour trouver la note la plus élevée
 *              parmi toutes les notes enregistrées dans la table 'notes'. Il affiche ensuite
 *              cette meilleure note sur la page web.
 *              Ce fichier est maintenant intégré dans l'application via index.php.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

// Requête SQL pour trouver la note maximale dans la table 'notes'.
// MAX(note) est une fonction d'agrégation qui retourne la valeur maximale de la colonne 'note'.
$sql = "SELECT MAX(note) AS meilleure_note FROM notes";
$result = $conn->query($sql);

$meilleure_note = "N/A"; // Valeur par défaut si aucune note n'est trouvée.

// Vérifie si la requête a retourné des résultats.
if ($result->num_rows > 0) {
    // Récupère la première (et unique) ligne de résultat.
    $row = $result->fetch_assoc();
    // Assigne la valeur de la meilleure note à la variable.
    $meilleure_note = $row["meilleure_note"];
}

// Fermeture de la connexion à la base de données.
$conn->close();

?>

        <h2>Meilleure Note</h2>
        <p>La meilleure note obtenue est : <span class="note-value"><?php echo $meilleure_note; ?></span></p>
