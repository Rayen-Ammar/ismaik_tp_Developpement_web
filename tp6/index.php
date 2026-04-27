<?php
/**
 * ==========================================================
 * FICHIER PRINCIPAL - GESTION DES ÉTUDIANTS
 * Projet : Gestion des Étudiants (TP6)
 * ==========================================================
 */

// Inclusion du fichier de configuration pour établir la connexion à la base de données
// Ce fichier contient les paramètres $host, $user, $password, $db et l'objet $conn
require_once 'config.php';

// Initialisation d'une variable pour stocker les messages de succès ou d'erreur
$message = "";

/**
 * PARTIE 4 : INSERTION DES DONNÉES
 * Traitement de la soumission du formulaire (méthode POST)
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter'])) {
    
    // 1. Récupération des données envoyées par le formulaire via $_POST
    // On utilise mysqli_real_escape_string pour protéger contre les injections SQL
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Conversion des notes en nombres flottants (float) pour les calculs
    $note1 = floatval($_POST['note1']);
    $note2 = floatval($_POST['note2']);
    $note3 = floatval($_POST['note3']);
    
    // 2. Calcul de la moyenne des trois notes
    $moyenne = ($note1 + $note2 + $note3) / 3;
    
    // 3. Préparation de la requête SQL d'insertion
    // On insère toutes les données dans la table 'etudiants'
    $sql_insert = "INSERT INTO etudiants (nom, prenom, email, note1, note2, note3, moyenne) 
                   VALUES ('$nom', '$prenom', '$email', $note1, $note2, $note3, $moyenne)";
    
    // 4. Exécution de la requête et vérification du résultat
    if ($conn->query($sql_insert) === TRUE) {
        // Message de succès si l'insertion a réussi
        $message = "<div class='alert alert-success'>L'étudiant <strong>$prenom $nom</strong> a été ajouté avec succès !</div>";
    } else {
        // Message d'erreur en cas de problème technique
        $message = "<div class='alert alert-danger'>Erreur lors de l'ajout : " . $conn->error . "</div>";
    }
}

/**
 * PARTIE 5 : AFFICHAGE DES DONNÉES
 * Récupération de la liste de tous les étudiants enregistrés
 */
$sql_select = "SELECT * FROM etudiants ORDER BY id DESC"; // On trie par ID décroissant pour voir les derniers ajouts en premier
$resultat = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants | TP6 PHP-MySQL</title>
    
    <!-- Lien vers la feuille de style CSS personnalisée pour le design ultra-pro -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Ajout d'icônes FontAwesome pour une interface plus moderne -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        
        <!-- En-tête de la page -->
        <header>
            <h1><i class="fas fa-graduation-cap"></i> GESTION ÉTUDIANTS</h1>
            <p>Système de gestion des notes et calcul de moyenne automatique</p>
        </header>

        <!-- Affichage du message de confirmation après ajout -->
        <?php echo $message; ?>

        <!-- PARTIE 3 : FORMULAIRE ÉTUDIANT -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-user-plus"></i> Ajouter un nouvel étudiant
            </div>
            
            <form action="index.php" method="POST">
                <div class="form-grid">
                    <!-- Informations personnelles -->
                    <div class="form-group">
                        <label for="nom">Nom de l'étudiant</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Ex: Ben Ahmed" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom de l'étudiant</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Ex: Mohamed" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Adresse Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Ex: mohamed@email.com" required>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 1rem;">
                    <!-- Saisie des notes -->
                    <div class="form-group">
                        <label for="note1">Note 1 (DS)</label>
                        <input type="number" step="0.01" min="0" max="20" name="note1" id="note1" class="form-control" placeholder="0.00" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="note2">Note 2 (Examen)</label>
                        <input type="number" step="0.01" min="0" max="20" name="note2" id="note2" class="form-control" placeholder="0.00" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="note3">Note 3 (TP)</label>
                        <input type="number" step="0.01" min="0" max="20" name="note3" id="note3" class="form-control" placeholder="0.00" required>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" name="ajouter" class="btn">
                    <i class="fas fa-save"></i> Enregistrer l'étudiant
                </button>
            </form>
        </div>

        <!-- PARTIE 5 & 6 : AFFICHAGE ET RÉSULTAT -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-list"></i> Liste des étudiants enregistrés
            </div>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Note 1</th>
                            <th>Note 2</th>
                            <th>Note 3</th>
                            <th>Moyenne</th>
                            <th>Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Vérification s'il y a des données à afficher
                        if ($resultat->num_rows > 0) {
                            // Parcours de chaque ligne de résultat
                            while($row = $resultat->fetch_assoc()) {
                                
                                // PARTIE 6 : CONDITION ADMIS / AJOURNÉ
                                // On détermine le statut en fonction de la moyenne
                                $moyenne_formattee = number_format($row['moyenne'], 2); // Formatage à 2 décimales
                                
                                if ($row['moyenne'] >= 10) {
                                    $statut = "<span class='badge badge-success'>Admis</span>";
                                } else {
                                    $statut = "<span class='badge badge-danger'>Ajourné</span>";
                                }
                                
                                // Affichage de la ligne dans le tableau HTML
                                echo "<tr>";
                                echo "<td>#" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . $row['note1'] . "</td>";
                                echo "<td>" . $row['note2'] . "</td>";
                                echo "<td>" . $row['note3'] . "</td>";
                                echo "<td><strong>" . $moyenne_formattee . "</strong></td>";
                                echo "<td>" . $statut . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Message si aucun étudiant n'est encore enregistré
                            echo "<tr><td colspan='8' style='text-align:center; padding: 2rem; color: #64748b;'>Aucun étudiant trouvé dans la base de données.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pied de page -->
        <footer style="text-align: center; margin-top: 2rem; color: #94a3b8; font-size: 0.875rem;">
            <p>&copy; 2026 - Projet TP6 Programmation Web - ISMAI Kairouan</p>
        </footer>

    </div>

</body>
</html>

<?php
// Fermeture de la connexion à la base de données à la fin du script
$conn->close();
?>
