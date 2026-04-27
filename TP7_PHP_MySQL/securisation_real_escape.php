<?php
/*
 * Fichier: securisation_real_escape.php
 * Description: Ce script PHP démontre l\"utilisation de la fonction mysqli_real_escape_string()
 *              pour sécuriser les entrées utilisateur avant de les utiliser dans une requête SQL.
 *              Ceci est une méthode pour prévenir les injections SQL, bien que les requêtes préparées
 *              (utilisées dans d\"autres fichiers de ce TP) soient généralement préférables pour une sécurité accrue.
 *              Ce fichier est maintenant intégré dans l\"application via index.php.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier de configuration de la base de données pour établir la connexion.
include_once 'db_config.php';

// Simule une entrée utilisateur (par exemple, depuis un formulaire POST).
// Pour la démonstration, nous utilisons une chaîne qui pourrait être malveillante.
$user_input_username = "admin' OR '1'='1"; // Exemple d'injection SQL
$user_input_password = "password";

echo "<h2>Démonstration de mysqli_real_escape_string</h2>";
echo "<p>Entrée utilisateur simulée pour le nom d'utilisateur: <code>" . htmlspecialchars($user_input_username) . "</code></p>";

// Utilisation de mysqli_real_escape_string pour échapper les caractères spéciaux.
// Cela rend la chaîne sûre à utiliser dans une requête SQL.
$escaped_username = $conn->real_escape_string($user_input_username);
$escaped_password = $conn->real_escape_string($user_input_password);

echo "<p>Nom d'utilisateur échappé avec <code>mysqli_real_escape_string</code>: <code>" . htmlspecialchars($escaped_username) . "</code></p>";

// Construction d'une requête SQL avec les valeurs échappées.
// Notez que pour une application réelle, les requêtes préparées sont la méthode préférée.
$sql_unsafe = "SELECT id, username FROM utilisateurs WHERE username = '$user_input_username' AND password = '$user_input_password'";
$sql_safe = "SELECT id, username FROM utilisateurs WHERE username = '$escaped_username' AND password = '$escaped_password'";

echo "<h3>Requête SQL (non sécurisée - pour démonstration):</h3>";
echo "<pre>" . htmlspecialchars($sql_unsafe) . "</pre>";

echo "<h3>Requête SQL (sécurisée avec real_escape_string):</h3>";
echo "<pre>" . htmlspecialchars($sql_safe) . "</pre>";

// Exécution de la requête sécurisée pour montrer le résultat.
$result = $conn->query($sql_safe);

if ($result) {
    if ($result->num_rows > 0) {
        echo "<p class='alert-success'>Requête sécurisée exécutée avec succès. Utilisateur(s) trouvé(s).</p>";
        while($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row['id'] . ", Nom d'utilisateur: " . $row['username'] . "</p>";
        }
    } else {
        echo "<p class='alert-danger'>Requête sécurisée exécutée. Aucun utilisateur trouvé (ce qui est attendu pour l'exemple d'injection).</p>";
    }
} else {
    echo "<p class='alert-danger'>Erreur lors de l'exécution de la requête: " . $conn->error . "</p>";
}

// Fermeture de la connexion à la base de données.
$conn->close();

?>
