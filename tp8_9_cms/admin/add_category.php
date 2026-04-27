<?php 
/*
 * FICHIER : admin/add_category.php
 * RÔLE : Interface permettant à l'administrateur de créer de nouvelles catégories.
 * Affiche également la liste des catégories existantes.
 */

// 1. Initialisation de la session
if(session_status() === PHP_SESSION_NONE) session_start();

// 2. Sécurité : Vérification que l'utilisateur est un Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: ../frontend/index.php"); 
    exit(); 
}

require_once '../config/db.php';
require_once '../includes/header.php'; 

// Variable pour stocker et afficher les messages d'erreur ou de succès
$msg = '';

// Si l'administrateur a soumis le formulaire d'ajout (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); // On nettoie le nom de la catégorie saisi
    
    // 3. Vérification des doublons : La catégorie existe-t-elle déjà ?
    $stmt_c = $conn->prepare("SELECT id FROM categories WHERE name=?");
    $stmt_c->bind_param("s", $name);
    $stmt_c->execute();
    
    // Si la requête renvoie plus de 0 lignes (donc elle existe)
    if($stmt_c->get_result()->num_rows > 0) {
        $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Cette catégorie existe déjà.</div>";
    } else {
        // 4. Insertion en BDD si la catégorie est bien nouvelle
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        
        // Exécution et test du résultat
        if($stmt->execute()) {
            $msg = "<div class='alert alert-success'><i class='fa-solid fa-check'></i> Catégorie ajoutée avec succès.</div>";
        } else {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-bug'></i> Erreur lors de l'ajout.</div>";
        }
        $stmt->close();
    }
    $stmt_c->close();
}
?>

<!-- Structure du panneau d'administration avec barre latérale (Sidebar) et zone principale (Main) -->
<div class="admin-layout">
    <!-- Barre latérale de navigation de l'administration -->
    <div class="admin-sidebar glass-card" style="align-self: flex-start; padding: 20px;">
        <h3 style="margin-bottom: 20px; font-size: 1.2rem; display:flex; align-items:center; gap:10px; color: var(--primary);"><i class="fa-solid fa-screwdriver-wrench"></i> Administration</h3>
        <div class="admin-menu">
            <a href="dashboard.php" class="admin-menu-item"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="add_article.php" class="admin-menu-item"><i class="fa-solid fa-pen-to-square"></i> Nouvel Article</a>
            <!-- Lien actif (en surbrillance) -->
            <a href="add_category.php" class="admin-menu-item active"><i class="fa-solid fa-folder-plus"></i> Catégories</a>
        </div>
    </div>
    
    <!-- Zone d'affichage et de formulaire -->
    <div class="admin-main glass-card">
        <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-layer-group text-secondary"></i> Gestion des Catégories</h2>
        <!-- Affichage du message système (erreur ou succès) -->
        <?= $msg ?>
        
        <!-- Organisation en flexbox : à gauche le formulaire, à droite la liste -->
        <div style="display: flex; flex-wrap: wrap; gap: 40px;">
            
            <!-- BLOC 1 : Formulaire d'ajout -->
            <div style="flex: 1; min-width: 300px;">
                <form method="POST" class="glass" style="padding: 20px; border-radius: 12px; border: 1px solid rgba(236, 72, 153, 0.3);">
                    <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-plus-circle"></i> Ajouter</h4>
                    <div class="form-group">
                        <label class="form-label">Nom de la nouvelle catégorie</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ex: Intelligence Artificielle">
                    </div>
                    <button class="btn btn-primary"><i class="fa-solid fa-save"></i> Enregistrer</button>
                </form>
            </div>
            
            <!-- BLOC 2 : Liste des catégories existantes -->
            <div style="flex: 1; min-width: 300px;">
                <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-list-ol"></i> Catégories Existantes</h4>
                <div class="glass" style="padding: 20px; border-radius: 12px; max-height: 350px; overflow-y: auto;">
                    <ul style="list-style: none;">
                        <?php
                        // Requête pour obtenir toutes les catégories par ordre alphabétique (ASC)
                        $list = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                        
                        if($list && $list->num_rows > 0){
                            // Affichage sous forme de liste <li>
                            while($l = $list->fetch_assoc()) {
                                echo "<li style='padding: 12px; border-bottom: 1px solid var(--glass-border); display:flex; align-items:center; gap:10px; font-weight:500;'><i class='fa-solid fa-tag text-primary'></i> " . htmlspecialchars($l['name']) . "</li>";
                            }
                        } else {
                            echo "<li style='color: var(--text-muted);'>Aucune catégorie.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pied de page -->
<?php require_once '../includes/footer.php'; ?>
