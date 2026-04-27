<?php 
/*
 * FICHIER : frontend/article.php
 * RÔLE : Afficher le contenu détaillé d'un article spécifique.
 * Gère également l'affichage et la soumission (vers actions/add_comment.php) des commentaires
 * pour cet article.
 */

// Import de l'en-tête (Navbar)
require_once '../includes/header.php'; 

// 1. Vérification de sécurité : Est-ce qu'on a bien l'ID de l'article dans l'URL (?id=...)
if(!isset($_GET['id'])) { 
    echo "<div class='alert alert-error'>Article introuvable.</div>"; 
    require_once '../includes/footer.php';
    exit; // Fin prématurée du script si aucun ID fourni
}

// Sécurisation de l'ID (on force le type en Entier)
$id = (int)$_GET['id'];

// 2. Requête SQL pour charger l'article depuis la base de données
$stmt = $conn->prepare("SELECT articles.*, categories.name as cat_name FROM articles LEFT JOIN categories ON articles.category_id = categories.id WHERE articles.id = ?");
$stmt->bind_param("i", $id); // 'i' = Integer
$stmt->execute();
$res = $stmt->get_result();

// Si l'article n'existe pas en BDD avec cet ID
if($res->num_rows === 0) {
    echo "<div class='alert alert-error'>Article introuvable.</div>"; 
    require_once '../includes/footer.php';
    exit;
}

// Extraction des données de l'article
$article = $res->fetch_assoc();

// Traitement de l'image (Image par défaut si vide)
$img = $article['image_url'] ? htmlspecialchars($article['image_url']) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800';
$date = new DateTime($article['created_at']);
?>

<!-- Bouton Retour -->
<a href="index.php" class="btn btn-outline" style="margin-bottom: 30px;"><i class="fa-solid fa-arrow-left"></i> Retour aux articles</a>

<!-- Bloc d'en-tête de l'article (Titre, Catégorie, Date) -->
<div class="article-header">
    <span class="article-cat" style="font-size: 1rem;"><i class="fa-solid fa-tag"></i> <?= htmlspecialchars($article['cat_name'] ?? 'Non catégorisé') ?></span>
    <h1><?= htmlspecialchars($article['title']) ?></h1>
    <div class="article-meta" style="justify-content: center; font-size: 1rem; margin-bottom: 20px;">
        <span><i class="fa-regular fa-calendar"></i> Publié le <?= $date->format('d M Y à H:i') ?></span>
    </div>
</div>

<!-- Image géante (Hero Image) -->
<img src="<?= $img ?>" class="article-hero-img" alt="Hero Image">

<!-- Bloc principal contenant le texte de l'article -->
<div class="article-content glass-card">
    <!-- nl2br convertit les retours à la ligne \n en balises HTML <br> -->
    <!-- htmlspecialchars protège contre les failles XSS en désactivant le HTML tapé par l'utilisateur -->
    <?= nl2br(htmlspecialchars($article['content'])) ?>
</div>

<!-- Section Commentaires -->
<div class="comments-section glass-card">
    <h3><i class="fa-regular fa-comments text-primary"></i> Espace Commentaires</h3>
    <hr style="border:0; border-top: 1px solid var(--glass-border); margin: 20px 0;">
    
    <!-- Liste des commentaires -->
    <div class="comments-list">
        <?php
        // 3. Charger tous les commentaires liés à cet article (jointure avec les utilisateurs pour le pseudo)
        $stmt_comm = $conn->prepare("SELECT comments.*, users.username, users.role FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE article_id = ? ORDER BY created_at ASC");
        $stmt_comm->bind_param("i", $id);
        $stmt_comm->execute();
        $coms = $stmt_comm->get_result();
        
        // Boucle pour afficher chaque commentaire
        if($coms->num_rows > 0) {
            while($c = $coms->fetch_assoc()) {
                $c_date = new DateTime($c['created_at']);
                $initial = strtoupper(substr($c['username'], 0, 1)); // Première lettre du pseudo pour l'avatar
                
                // HTML du bloc de commentaire
                echo "<div class='comment-box'>";
                echo "<div class='comment-avatar'>{$initial}</div>";
                echo "<div class='comment-content'>";
                // Distinction visuelle pour l'Admin avec une icône de bouclier (user-shield)
                echo "<div class='comment-author'><span>" . ($c['role']=='admin'?"<i class='fa-solid fa-user-shield text-primary' title='Administrateur'></i> ":"<i class='fa-regular fa-user text-muted'></i> ") . htmlspecialchars($c['username']) . "</span><span class='comment-date'>{$c_date->format('d/m/Y H:i')}</span></div>";
                echo "<div class='comment-text'>" . nl2br(htmlspecialchars($c['content'])) . "</div>";
                echo "</div></div>";
            }
        } else {
            // Aucun commentaire
            echo "<p style='color: var(--text-muted); font-style:italic;'><i class='fa-regular fa-comment-dots'></i> Soyez le premier à commenter !</p>";
        }
        ?>
    </div>
    
    <!-- Ajout d'un nouveau commentaire -->
    <div style="margin-top: 40px;">
        <?php if(isset($_SESSION['user_id'])): // L'utilisateur est-il connecté ? ?>
            <!-- Formulaire pour poster envoyé vers le script de traitement : add_comment.php -->
            <form method="POST" action="../actions/add_comment.php" class="glass" style="padding: 20px; border-radius: 12px; border: 1px solid rgba(79, 70, 229, 0.3);">
                <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-pen text-secondary"></i> Rédiger un commentaire</h4>
                <!-- L'ID de l'article est envoyé clandestinement (hidden) -->
                <input type="hidden" name="article_id" value="<?= $id ?>">
                <textarea name="content" class="form-control" rows="4" required placeholder="Votre avis constructif ici..."></textarea>
                <div style="text-align: right; margin-top: 15px;">
                    <button class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Publier</button>
                </div>
            </form>
        <?php else: // Utilisateur non connecté ?>
            <!-- Message l'invitant à se connecter s'il veut poster un message -->
            <div class="glass" style="padding: 20px; border-radius: 12px; text-align: center;">
                <p style="margin-bottom: 15px;"><i class="fa-solid fa-lock text-muted" style="font-size: 2rem;"></i></p>
                <p>Vous devez être connecté pour participer à la discussion.</p>
                <div style="margin-top: 15px; display:flex; gap: 10px; justify-content: center;">
                    <a href="../auth/login.php" class="btn btn-outline"><i class="fa-solid fa-user"></i> Se connecter</a>
                    <a href="../auth/register.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> S'inscrire</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Import du pied de page -->
<?php require_once '../includes/footer.php'; ?>
