<?php 
/*
 * FICHIER : auth/login.php
 * RÔLE : Formulaire de connexion des utilisateurs.
 * Vérifie les identifiants fournis (nom d'utilisateur et mot de passe) par rapport à la base de données,
 * gère le hachage sécurisé (password_verify) et démarre la session utilisateur en cas de succès.
 */

// On inclut l'en-tête (qui gère la navbar et le design)
require_once '../includes/header.php'; 
?>
<!-- Boîte contenant le formulaire de connexion (Stylisée avec Glassmorphism) -->
<div class="auth-container glass-card">
    <h2><i class="fa-solid fa-right-to-bracket text-primary"></i> Bon Retour</h2>
    <p class="subtitle">Connectez-vous pour continuer</p>
    
    <?php
    // Si la page a été appelée suite à la soumission du formulaire (méthode POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // On récupère les données envoyées et on nettoie les espaces avant/après (trim)
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        // 1. On prépare une requête SQL pour chercher l'utilisateur par son pseudo
        // Sécurité : On utilise prepare() pour se protéger contre les Injections SQL
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // 's' signifie que le paramètre est un String (chaîne de caractères)
        $stmt->execute();
        $res = $stmt->get_result(); // On récupère le résultat de la requête
        
        // 2. On vérifie si un utilisateur avec ce pseudo existe dans la base
        if ($res->num_rows > 0) {
            $user = $res->fetch_assoc(); // Extraction des données de l'utilisateur sous forme de tableau associatif
            
            // 3. On vérifie si le mot de passe tapé correspond au mot de passe sécurisé (haché) en base
            if (password_verify($password, $user['password'])) {
                // Succès : On sauvegarde les infos de l'utilisateur dans la Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirection vers la page d'accueil après une connexion réussie
                echo "<script>window.location.href='../frontend/index.php';</script>";
                exit; // On arrête l'exécution du reste du code
            } else {
                // Echec : Le mot de passe est faux
                echo "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Mot de passe incorrect</div>";
            }
        } else {
            // Echec : Aucun utilisateur ne porte ce pseudo
            echo "<div class='alert alert-error'><i class='fa-solid fa-user-xmark'></i> Utilisateur non trouvé</div>";
        }
        $stmt->close(); // Fermeture de la requête préparée
    }
    ?>
    
    <!-- Formulaire d'envoi des identifiants (POST vers cette même page) -->
    <form method="POST" style="text-align: left;">
        <div class="form-group">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required placeholder="Votre pseudo">
        </div>
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required placeholder="••••••••">
        </div>
        <!-- Bouton de soumission du formulaire -->
        <button class="btn btn-primary" style="width: 100%; justify-content: center;"><i class="fa-solid fa-unlock-keyhole"></i> Se connecter</button>
    </form>
    
    <!-- Lien vers la page d'inscription pour les nouveaux utilisateurs -->
    <div style="margin-top: 20px;">
        <a href="register.php" style="color: var(--text-muted); font-size: 0.9rem;">Pas encore de compte ? <span style="color: var(--primary);">Créer un compte</span></a>
    </div>
</div>

<!-- On inclut le pied de page pour refermer le HTML -->
<?php require_once '../includes/footer.php'; ?>
