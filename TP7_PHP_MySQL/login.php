<?php
/*
 * Fichier: login.php
 * Description: Ce fichier contient le formulaire HTML permettant aux utilisateurs de se connecter.
 *              Il demande un nom d\'utilisateur et un mot de passe, puis envoie ces informations
 *              au script \'verification.php\' via la méthode POST pour authentification.
 *              Il inclut maintenant l\'en-tête et le pied de page de l\'application pour une intégration complète.
 * Auteur: [Ammar Rayen]
 */

// Inclut le fichier d\'en-tête qui contient le début du HTML et les styles CSS.
// La logique de redirection pour les utilisateurs non connectés est gérée dans header.php.
include_once 'header.php';

// Si l\'utilisateur est déjà connecté, il est redirigé vers la page d\'accueil.
// Cela évite qu\'un utilisateur déjà authentifié ne voie le formulaire de connexion.
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

?>

        <h2 style="text-align: center; color: #007bff;">Connexion</h2>
        <!-- Le formulaire envoie les données à \'verification.php\' via la méthode POST -->
        <form action="verification.php" method="post" style="max-width: 400px; margin: 0 auto;">
            <!-- Champ pour le nom d\'utilisateur -->
            <label for="username">Nom d\'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            
            <!-- Champ pour le mot de passe -->
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            
            <!-- Bouton de soumission du formulaire -->
            <input type="submit" value="Se connecter">
        </form>

<?php
// Inclut le fichier de pied de page qui contient la fin du HTML.
include_once 'footer.php';
?>
