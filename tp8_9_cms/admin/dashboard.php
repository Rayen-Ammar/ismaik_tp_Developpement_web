<?php 
/*
 * FICHIER : admin/dashboard.php
 * RÔLE : Tableau de bord principal de l'administration.
 * Affiche des statistiques globales (nombre d'articles, d'utilisateurs, de commentaires)
 * et liste les derniers articles ajoutés avec des options de modification/suppression.
 */

// 1. Démarrage de session et vérification des droits Admin
if(session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirection immédiate si ce n'est pas un administrateur
    header("Location: ../frontend/index.php");
    exit();
}

require_once '../config/db.php';
require_once '../includes/header.php'; 

// 2. Récupération des statistiques via 3 requêtes SQL "COUNT" rapides
$total_articles = $conn->query("SELECT COUNT(*) as count FROM articles")->fetch_assoc()['count'];
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_comments = $conn->query("SELECT COUNT(*) as count FROM comments")->fetch_assoc()['count'];
?>
<div class="admin-layout">
    <!-- Barre latérale -->
    <div class="admin-sidebar glass-card" style="align-self: flex-start; padding: 20px;">
        <h3 style="margin-bottom: 20px; font-size: 1.2rem; display:flex; align-items:center; gap:10px; color: var(--primary);"><i class="fa-solid fa-screwdriver-wrench"></i> Administration</h3>
        <div class="admin-menu">
            <!-- Lien actif -->
            <a href="dashboard.php" class="admin-menu-item active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="add_article.php" class="admin-menu-item"><i class="fa-solid fa-pen-to-square"></i> Nouvel Article</a>
            <a href="add_category.php" class="admin-menu-item"><i class="fa-solid fa-folder-plus"></i> Catégories</a>
        </div>
    </div>
    
    <!-- Zone principale -->
    <div class="admin-main">
        <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-bolt text-secondary"></i> Aperçu des statistiques</h2>
        
        <!-- Cartes de statistiques (Grid Layout) -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div class="glass-card" style="text-align:center; padding: 30px; border-top: 4px solid var(--primary);">
                <i class="fa-solid fa-file-lines text-primary" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                <h3 style="font-size: 2.5rem; margin-bottom: 5px;"><?= $total_articles ?></h3>
                <p class="text-muted" style="text-transform: uppercase; font-weight:600; letter-spacing:1px; font-size:0.8rem;">Articles</p>
            </div>
            <div class="glass-card" style="text-align:center; padding: 30px; border-top: 4px solid var(--secondary);">
                <i class="fa-solid fa-users text-secondary" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
                <h3 style="font-size: 2.5rem; margin-bottom: 5px;"><?= $total_users ?></h3>
                <p class="text-muted" style="text-transform: uppercase; font-weight:600; letter-spacing:1px; font-size:0.8rem;">Membres</p>
            </div>
            <div class="glass-card" style="text-align:center; padding: 30px; border-top: 4px solid var(--green-500);">
                <i class="fa-regular fa-comments" style="font-size: 2.5rem; margin-bottom: 15px; color:#10b981;"></i>
                <h3 style="font-size: 2.5rem; margin-bottom: 5px;"><?= $total_comments ?></h3>
                <p class="text-muted" style="text-transform: uppercase; font-weight:600; letter-spacing:1px; font-size:0.8rem;">Commentaires</p>
            </div>
        </div>

        <!-- Tableau des derniers articles -->
        <div class="glass-card" style="padding: 20px;">
            <!-- Bouton Ajouter : uniquement visible pour l'admin (Partie 5 TP9) -->
            <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <h3><i class="fa-solid fa-list-ul"></i> Gestion de tous les articles</h3>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="add_article.php" class="btn btn-primary" style="font-size: 0.9rem;"><i class="fa-solid fa-plus"></i> Ajouter un article</a>
                <?php endif; ?>
            </div>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Actions</th> <!-- Colonne d'administration -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // 3. Récupération de TOUS les articles (TP9 : CRUD complet - Read ALL)
                        $recent = $conn->query("SELECT id, title, created_at FROM articles ORDER BY created_at DESC");
                        if($recent && $recent->num_rows > 0) {
                            while($r = $recent->fetch_assoc()) {
                                $d = new DateTime($r['created_at']);
                                echo "<tr>";
                                echo "<td><strong>" . htmlspecialchars($r['title']) . "</strong></td>";
                                echo "<td><span class='text-muted'><i class='fa-regular fa-calendar'></i> {$d->format('d/m/Y H:i')}</span></td>";
                                
                                // Boutons d'Action selon le rôle (Partie 5 & 6 TP9)
                                echo "<td style='display:flex; gap:5px;'>";
                                // Bouton Voir (accessible à tous les connectés)
                                echo "<a href='../frontend/article.php?id={$r['id']}' class='btn btn-outline' style='padding: 5px 10px; font-size:0.8rem;' title='Voir'><i class='fa-solid fa-eye'></i></a>";
                                // Bouton Modifier : uniquement pour l'admin (Partie 6 TP9)
                                if ($_SESSION['role'] == 'admin') {
                                    echo "<a href='edit_article.php?id={$r['id']}' class='btn btn-outline' style='padding: 5px 10px; font-size:0.8rem; color: var(--primary); border-color: var(--primary);' title='Modifier'><i class='fa-solid fa-pen'></i></a>";
                                    // Bouton Supprimer : pointe vers actions/delete_article.php (TP9 Partie 3)
                                    echo "<a href='../actions/delete_article.php?id={$r['id']}' class='btn btn-outline' style='padding: 5px 10px; font-size:0.8rem; color: #ef4444; border-color: #ef4444;' title='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet article définitivement ?\");'><i class='fa-solid fa-trash'></i></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' style='text-align:center; color: var(--text-muted);'>Aucun article pour le moment.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
