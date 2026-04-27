<?php 
/*
 * FICHIER : auth/register.php
 * RÔLE : Formulaire d'inscription de nouveaux membres.
 * Reçoit un pseudo et un mot de passe, vérifie si le pseudo n'est pas déjà pris
 * dans la base de données, puis crée le compte en sécurisant le mot de passe (hachage).
 */

require_once '../includes/header.php'; 
?>
<div class="auth-container glass-card">
    <h2><i class="fa-solid fa-user-plus text-secondary"></i> Inscription</h2>
    <p class="subtitle">Rejoignez la communauté pro</p>
    
    <?php
    // Si l'utilisateur a cliqué sur "S'inscrire" (Envoi du formulaire POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nettoyage et récupération des données
        $username = trim($_POST['username']);
        
        // SECURITE CRITIQUE : Hachage du mot de passe avec l'algorithme robuste par défaut (Bcrypt)
        // Ne jamais stocker de mots de passe en texte clair !
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        
        // 1. Vérification des doublons : Ce nom d'utilisateur existe-t-il déjà ?
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        
        // Si oui, on affiche une erreur et on arrête le processus
        if($stmt_check->get_result()->num_rows > 0) {
            echo "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Ce nom d'utilisateur est déjà pris.</div>";
        } else {
            // 2. Si le pseudo est libre, on fait l'insertion dans la base de données
            // Rôle par défaut : Tous les nouveaux inscrits ont le rôle 'user' en BDD (défini dans SQL)
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            
            // Exécution et vérification du succès de l'insertion
            if ($stmt->execute()) {
                // Message de succès avec un lien pour aller se connecter
                echo "<div class='alert alert-success'><i class='fa-solid fa-check-circle'></i> Compte créé avec succès ! <br><a href='login.php' style='color:inherit;text-decoration:underline;margin-top:10px;display:inline-block;'>Cliquez ici pour vous connecter</a></div>";
            } else {
                echo "<div class='alert alert-error'><i class='fa-solid fa-bug'></i> Erreur lors de l'inscription.</div>";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
    ?>
    
    <!-- Formulaire d'inscription -->
    <form method="POST" style="text-align: left;">
        <div class="form-group">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required placeholder="Choisissez un pseudo">
        </div>
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <!-- L'attribut required oblige que le champ soit rempli -->
            <input type="password" name="password" class="form-control" required placeholder="Minimum 6 caractères">
        </div>
        <button class="btn btn-primary" style="width: 100%; justify-content: center;"><i class="fa-solid fa-paper-plane"></i> S'inscrire</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>
