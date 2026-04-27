<?php
/*
 * FICHIER : frontend/user_dashboard.php
 * RÔLE : Espace personnel du membre (rôle = 'user').
 * Permet à l'utilisateur connecté de lire tous les articles et laisser des commentaires.
 * Un utilisateur ordinaire n'a PAS accès aux fonctions d'administration (Partie 5 TP9).
 * Résultat attendu TP9 : user → lecture + commentaires uniquement ✅
 */

// 1. Démarrage de session et vérification de connexion
if (session_status() === PHP_SESSION_NONE) session_start();

// Si non connecté → redirection vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Import de la BDD et de l'en-tête (Navbar + CSS)
require_once '../config/db.php';
require_once '../includes/header.php';

// 2. Récupérer les statistiques de l'utilisateur
$uid = (int)$_SESSION['user_id'];

// Nombre de commentaires postés par cet utilisateur
$stmt_count = $conn->prepare("SELECT COUNT(*) as total FROM comments WHERE user_id = ?");
$stmt_count->bind_param("i", $uid);
$stmt_count->execute();
$count_comments = $stmt_count->get_result()->fetch_assoc()['total'];
$stmt_count->close();

// Nombre total d'articles disponibles
$total_articles = $conn->query("SELECT COUNT(*) as count FROM articles")->fetch_assoc()['count'];

// 3. Récupérer tous les articles pour les afficher
$articles = $conn->query(
    "SELECT articles.*, categories.name as cat_name 
     FROM articles 
     LEFT JOIN categories ON articles.category_id = categories.id 
     ORDER BY articles.created_at DESC"
);
?>

<!-- ═══════════════════════════════════════════════════
     HERO CARD : Bienvenue Utilisateur
════════════════════════════════════════════════════════ -->
<div style="margin-bottom: 40px; animation: slideDown 0.5s ease;">
    <div class="glass-card" style="
        padding: 35px 40px; 
        background: linear-gradient(135deg, rgba(79,70,229,0.15) 0%, rgba(139,92,246,0.1) 100%);
        border: 1px solid rgba(79,70,229,0.25);
        position: relative; overflow: hidden;
    ">
        <!-- Décoration d'arrière-plan -->
        <div style="position:absolute; top:-40px; right:-40px; width:200px; height:200px; background: radial-gradient(circle, rgba(79,70,229,0.15) 0%, transparent 70%); pointer-events:none;"></div>
        <div style="position:absolute; bottom:-30px; left:20%; width:150px; height:150px; background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%); pointer-events:none;"></div>
        
        <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap; position:relative; z-index:1;">
            <!-- Avatar animé -->
            <div style="
                width: 90px; height: 90px; border-radius: 50%; flex-shrink: 0;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                display: flex; align-items: center; justify-content: center;
                font-size: 2.2rem; font-weight: 900;
                box-shadow: 0 0 30px rgba(79,70,229,0.4);
                border: 3px solid rgba(255,255,255,0.15);
            ">
                <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
            </div>
            
            <div style="flex: 1;">
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 5px; letter-spacing: 1px; text-transform: uppercase;">
                    <i class="fa-solid fa-circle" style="color: #10b981; font-size: 0.5rem; vertical-align: middle;"></i> Membre actif
                </p>
                <h1 style="font-size: 2rem; margin-bottom: 8px; line-height: 1.2;">
                    Bonjour, <span style="background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?= htmlspecialchars($_SESSION['username']) ?></span> 👋
                </h1>
                <p style="color: var(--text-muted); display: flex; align-items: center; gap: 8px; font-size: 0.95rem; flex-wrap: wrap;">
                    <span style="background: rgba(79,70,229,0.12); border: 1px solid rgba(79,70,229,0.2); padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; color: var(--primary);">
                        <i class="fa-solid fa-user-tag"></i> Rôle : Utilisateur
                    </span>
                    <span style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); padding: 3px 12px; border-radius: 20px; font-size: 0.8rem; color: #f59e0b;">
                        <i class="fa-solid fa-lock"></i> Accès : Lecture + Commentaires
                    </span>
                </p>
            </div>
            
            <!-- Stats rapides -->
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <!-- Stat : Commentaires -->
                <div style="
                    text-align: center; 
                    background: rgba(79,70,229,0.1); 
                    border: 1px solid rgba(79,70,229,0.2); 
                    border-radius: 16px; padding: 18px 25px;
                    min-width: 110px;
                ">
                    <div style="font-size: 2.2rem; font-weight: 800; color: var(--primary); line-height: 1;"><?= $count_comments ?></div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px;">
                        <i class="fa-regular fa-comment"></i> Commentaires
                    </div>
                </div>
                <!-- Stat : Articles dispo -->
                <div style="
                    text-align: center;
                    background: rgba(139,92,246,0.1);
                    border: 1px solid rgba(139,92,246,0.2);
                    border-radius: 16px; padding: 18px 25px;
                    min-width: 110px;
                ">
                    <div style="font-size: 2.2rem; font-weight: 800; color: var(--secondary); line-height: 1;"><?= $total_articles ?></div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px;">
                        <i class="fa-regular fa-file-lines"></i> Articles dispo
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════
     BANDEAU INFO DROITS (Partie 5 TP9)
════════════════════════════════════════════════════════ -->
<div style="
    background: rgba(245,158,11,0.08); 
    border: 1px solid rgba(245,158,11,0.25); 
    border-left: 4px solid #f59e0b;
    border-radius: 12px; padding: 16px 22px; margin-bottom: 40px;
    display: flex; gap: 15px; align-items: center;
    animation: slideDown 0.6s ease 0.1s both;
">
    <i class="fa-solid fa-shield-halved" style="color: #f59e0b; font-size: 1.5rem; flex-shrink: 0;"></i>
    <div>
        <strong style="color: #f59e0b; font-size: 0.95rem;">Information sur vos droits d'accès</strong>
        <p style="color: var(--text-muted); font-size: 0.88rem; margin: 4px 0 0;">
            En tant que <strong>membre</strong>, vous pouvez <span style="color: #10b981;">lire</span> tous les articles et <span style="color: #10b981;">laisser des commentaires</span>.
            Les actions d'<strong>administration</strong> (Ajouter / Modifier / Supprimer des articles) sont réservées aux administrateurs.
        </p>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════
     TITRE SECTION ARTICLES
════════════════════════════════════════════════════════ -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; gap: 10px;">
    <h2 style="font-size: 1.6rem;">
        <i class="fa-solid fa-newspaper" style="color: var(--primary);"></i> Tous les articles
        <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 400; margin-left: 10px;"><?= $total_articles ?> article(s) disponible(s)</span>
    </h2>
    <a href="index.php" class="btn btn-outline" style="font-size: 0.85rem;">
        <i class="fa-solid fa-globe"></i> Voir le site public
    </a>
</div>

<!-- ═══════════════════════════════════════════════════
     GRILLE DES ARTICLES (Lecture seule pour le user)
════════════════════════════════════════════════════════ -->
<div class="articles-grid">
    <?php
    if ($articles && $articles->num_rows > 0) {
        while ($row = $articles->fetch_assoc()) {
            $date = new DateTime($row['created_at']);
            $img = $row['image_url']
                ? htmlspecialchars($row['image_url'])
                : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800';

            // Carte article (lien vers page complète pour lire + commenter)
            // NOTE TP9 Partie 6 : Aucun bouton Modifier/Supprimer affiché pour le user ✅
            echo "<a href='article.php?id={$row['id']}' class='article-card glass-card' style='padding: 15px; text-decoration: none;'>";
            echo "<div style='overflow:hidden; border-radius:12px; position:relative;'>";
            echo "<img src='{$img}' class='article-img'>";
            // Badge "Lire" au survol
            echo "<div style='position:absolute; inset:0; background:rgba(79,70,229,0.6); display:flex; align-items:center; justify-content:center; opacity:0; transition:0.3s; border-radius:12px;' class='card-overlay'><span style=\"background:white; color: var(--primary); padding: 8px 20px; border-radius:30px; font-weight:700; font-size:0.9rem;\"><i class='fa-solid fa-book-open'></i> Lire l'article</span></div>";
            echo "</div>";
            echo "<div style='padding: 12px 5px 0;'>";
            echo "<span class='article-cat'><i class='fa-solid fa-tag'></i> " . htmlspecialchars($row['cat_name'] ?? 'Non catégorisé') . "</span>";
            echo "<h3 class='article-title'>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<div class='article-meta'><span><i class='fa-regular fa-clock'></i> " . $date->format('d M. Y') . "</span><span style='color: var(--primary); font-size:0.8rem;'><i class='fa-solid fa-comment'></i> Commenter</span></div>";
            echo "</div></a>";
        }
    } else {
        echo "<div class='glass-card' style='grid-column: 1 / -1; text-align:center; padding: 60px 40px;'>
                <i class='fa-solid fa-ghost text-muted' style='font-size: 3.5rem; margin-bottom: 20px; display:block;'></i>
                <h3 style='color: var(--text-muted);'>Aucun article disponible</h3>
                <p style='color: var(--text-muted); font-size: 0.9rem;'>Revenez plus tard, de nouveaux contenus arrivent bientôt.</p>
              </div>";
    }
    ?>
</div>

<!-- CSS inline pour l'overlay au survol -->
<style>
.article-card:hover .card-overlay { opacity: 1 !important; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php require_once '../includes/footer.php'; ?>
