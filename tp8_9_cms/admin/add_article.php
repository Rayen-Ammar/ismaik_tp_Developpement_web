<?php 
/*
 * FICHIER : admin/add_article.php
 * RÔLE : Formulaire de création d'un nouvel article par l'administrateur.
 * Gère le téléversement des données (Titre, Contenu, Catégorie, Image URL) 
 * et leur insertion dans la table `articles`.
 */

// 1. Démarrage de session et Sécurité
if(session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header("Location: ../frontend/index.php"); 
    exit(); 
}

require_once '../config/db.php';
require_once '../includes/header.php'; 

// Variable gérant les messages (succès ou erreur) à afficher
$msg = '';

// Si le formulaire est soumis (Bouton "Publier l'article" cliqué)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. Nettoyage et récupération des données du formulaire
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $cat     = (int)$_POST['category_id'];
    $img     = trim($_POST['image_url']); // URL saisie manuellement

    // ─── Gestion de l'upload de fichier (image depuis le PC) ───────────────────
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file      = $_FILES['image_file'];
        $allowed   = ['image/jpeg', 'image/png', 'image/webp', 'image/gif']; // Types autorisés
        $max_size  = 5 * 1024 * 1024; // 5 Mo maximum

        if (!in_array($file['type'], $allowed)) {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Format non autorisé. Utilisez JPG, PNG, WebP ou GIF.</div>";
        } elseif ($file['size'] > $max_size) {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Fichier trop lourd (max 5 Mo).</div>";
        } else {
            // Nom de fichier unique pour éviter les conflits (timestamp + nom original nettoyé)
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
            $dest     = dirname(__DIR__) . '/assets/uploads/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $img = BASE_URL . '/assets/uploads/' . $filename; // On stocke l'URL relative
            } else {
                $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Erreur lors de l'enregistrement du fichier.</div>";
            }
        }
    }
    // ─────────────────────────────────────────────────────────────────────────────

    // Si aucune image uploadée ni URL saisie → image par défaut
    if (empty($img)) $img = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800';

    // 3. Insertion en Base de Données (seulement si pas d'erreur d'upload)
    if (empty($msg)) {
        $stmt = $conn->prepare("INSERT INTO articles (title, content, category_id, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $content, $cat, $img);
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'><i class='fa-solid fa-check-double'></i> Votre article a été publié avec succès.</div>";
        } else {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Erreur lors de la publication.</div>";
        }
        $stmt->close();
    }
}
?>

<!-- Structure du panneau d'administration -->
<div class="admin-layout">
    <!-- Barre latérale -->
    <div class="admin-sidebar glass-card" style="align-self: flex-start; padding: 20px;">
        <h3 style="margin-bottom: 20px; font-size: 1.2rem; display:flex; align-items:center; gap:10px; color: var(--primary);"><i class="fa-solid fa-screwdriver-wrench"></i> Administration</h3>
        <div class="admin-menu">
            <a href="dashboard.php" class="admin-menu-item"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="add_article.php" class="admin-menu-item active"><i class="fa-solid fa-pen-to-square"></i> Nouvel Article</a>
            <a href="add_category.php" class="admin-menu-item"><i class="fa-solid fa-folder-plus"></i> Catégories</a>
        </div>
    </div>
    
    <!-- Espace principal : Le Formulaire -->
    <div class="admin-main glass-card">
        <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-pen-nib text-primary"></i> Rédiger un nouvel article</h2>
        <?= $msg ?>
        
        <!-- enctype="multipart/form-data" obligatoire pour envoyer des fichiers -->
        <form method="POST" enctype="multipart/form-data">
            <!-- Champ : Titre -->
            <div class="form-group">
                <label class="form-label">Titre de l'article</label>
                <input type="text" name="title" class="form-control" required placeholder="Ex: Les tendances Web en 2026" style="font-size: 1.1rem; padding: 15px;">
            </div>
            
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <!-- Champ : Sélection de la catégorie -->
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label">Catégorie</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-folder text-muted" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%);"></i>
                        <select name="category_id" class="form-control" required style="padding-left: 45px; cursor: pointer; appearance: none;">
                            <?php
                            // Récupération dynamique des catégories depuis MySQL pour remplir le Select (<option>)
                            $cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                            if($cats && $cats->num_rows > 0) {
                                while($c = $cats->fetch_assoc()) {
                                    echo "<option style='color:#000' value='{$c['id']}'>" . htmlspecialchars($c['name']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled selected>Créez d'abord une catégorie !</option>";
                            }
                            ?>
                        </select>
                        <!-- Icône chevron décorative -->
                        <i class="fa-solid fa-chevron-down text-muted" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                    </div>
                </div>
                
                <!-- Champ : Image (Upload PC ou URL) -->
                <div class="form-group" style="flex: 2; min-width: 300px;">
                    <label class="form-label">Image de couverture</label>

                    <!-- Tabs Upload / URL -->
                    <div style="display:flex; border-radius:10px; overflow:hidden; border: 1px solid var(--glass-border); margin-bottom: 12px;">
                        <button type="button" id="tab-upload" onclick="switchTab('upload')" style="flex:1; padding:8px; background: var(--primary); color:#fff; border:none; cursor:pointer; font-weight:600; font-size:0.85rem; transition:0.2s;">
                            <i class="fa-solid fa-upload"></i> Depuis le PC
                        </button>
                        <button type="button" id="tab-url" onclick="switchTab('url')" style="flex:1; padding:8px; background:transparent; color:var(--text-muted); border:none; cursor:pointer; font-size:0.85rem; transition:0.2s;">
                            <i class="fa-solid fa-link"></i> Lien URL
                        </button>
                    </div>

                    <!-- Zone Upload depuis PC -->
                    <div id="zone-upload">
                        <label for="image_file" style="
                            display:flex; flex-direction:column; align-items:center; justify-content:center;
                            border: 2px dashed rgba(79,70,229,0.4); border-radius:12px; padding:25px;
                            cursor:pointer; background:rgba(79,70,229,0.05); transition:0.3s;
                            color:var(--text-muted);
                        " id="drop-label" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='rgba(79,70,229,0.4)'">
                            <i class="fa-solid fa-cloud-arrow-up" id="upload-icon" style="font-size:2rem; margin-bottom:10px; color:var(--primary);"></i>
                            <span id="upload-text" style="font-weight:600;">Cliquez ou déposez votre image ici</span>
                            <span style="font-size:0.78rem; margin-top:5px;">JPG, PNG, WebP, GIF · Max 5 Mo</span>
                        </label>
                        <input type="file" name="image_file" id="image_file" accept="image/*" style="display:none;" onchange="previewImage(this)">
                    </div>

                    <!-- Zone URL (cachée par défaut) -->
                    <div id="zone-url" style="display:none;">
                        <div style="position: relative;">
                            <i class="fa-solid fa-image text-muted" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%);"></i>
                            <input type="url" name="image_url" id="image_url" class="form-control" placeholder="https://..." style="padding-left: 45px;">
                        </div>
                    </div>

                    <!-- Prévisualisation -->
                    <div id="img-preview" style="display:none; margin-top:12px;">
                        <img id="preview-src" src="" style="width:100%; max-height:180px; object-fit:cover; border-radius:10px; border:1px solid var(--glass-border);">
                    </div>
                </div>
            </div>
            
            <!-- Champ : Contenu de l'article texte long -->
            <div class="form-group">
                <label class="form-label">Contenu éditorial</label>
                <!-- Un <textarea> permet de sauter des lignes (qui seront gérées par nl2br en frontend) -->
                <textarea name="content" class="form-control" rows="12" required placeholder="Saisissez votre contenu ici... Les sauts de ligne sont pris en compte via nl2br()." style="resize: vertical;"></textarea>
            </div>
            
            <div style="text-align: right; margin-top: 30px;">
                <button class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 30px;"><i class="fa-solid fa-rocket"></i> Publier l'article</button>
            </div>
        </form>
    </div>
</div>

<script>
// Basculer entre l'onglet "Upload PC" et "URL"
function switchTab(tab) {
    const zoneUpload = document.getElementById('zone-upload');
    const zoneUrl    = document.getElementById('zone-url');
    const tabUpload  = document.getElementById('tab-upload');
    const tabUrl     = document.getElementById('tab-url');
    const preview    = document.getElementById('img-preview');

    if (tab === 'upload') {
        zoneUpload.style.display = 'block';
        zoneUrl.style.display    = 'none';
        tabUpload.style.background = 'var(--primary)';
        tabUpload.style.color      = '#fff';
        tabUrl.style.background    = 'transparent';
        tabUrl.style.color         = 'var(--text-muted)';
        // Vider le champ URL quand on passe en mode upload
        document.getElementById('image_url').value = '';
    } else {
        zoneUrl.style.display    = 'block';
        zoneUpload.style.display = 'none';
        tabUrl.style.background    = 'var(--primary)';
        tabUrl.style.color         = '#fff';
        tabUpload.style.background = 'transparent';
        tabUpload.style.color      = 'var(--text-muted)';
        // Vider le champ fichier quand on passe en mode URL
        document.getElementById('image_file').value = '';
        preview.style.display = 'none';
    }
}

// Prévisualiser l'image sélectionnée depuis le PC
function previewImage(input) {
    const preview   = document.getElementById('img-preview');
    const previewEl = document.getElementById('preview-src');
    const text      = document.getElementById('upload-text');
    const icon      = document.getElementById('upload-icon');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewEl.src      = e.target.result;
            preview.style.display = 'block';
            text.textContent   = input.files[0].name; // Affiche le nom du fichier
            icon.className     = 'fa-solid fa-circle-check';
            icon.style.color   = '#10b981'; // Vert = OK
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Prévisualiser quand on saisit un lien URL
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('image_url');
    if (urlInput) {
        urlInput.addEventListener('input', function() {
            const preview   = document.getElementById('img-preview');
            const previewEl = document.getElementById('preview-src');
            if (this.value) {
                previewEl.src = this.value;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>

