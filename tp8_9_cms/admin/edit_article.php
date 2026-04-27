<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../frontend/index.php");
    exit();
}
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}
$id = (int) $_GET['id'];

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $cat     = (int) $_POST['category_id'];
    $img     = trim($_POST['image_url']); // URL saisie manuellement (peut être vide)

    // ─── Gestion de l'upload de fichier depuis le PC ───────────────────────
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $file     = $_FILES['image_file'];
        $allowed  = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5 Mo

        if (!in_array($file['type'], $allowed)) {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Format non autorisé. Utilisez JPG, PNG, WebP ou GIF.</div>";
        } elseif ($file['size'] > $max_size) {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Fichier trop lourd (max 5 Mo).</div>";
        } else {
            $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
            $dest     = dirname(__DIR__) . '/assets/uploads/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $img = BASE_URL . '/assets/uploads/' . $filename;
            } else {
                $msg = "<div class='alert alert-error'><i class='fa-solid fa-triangle-exclamation'></i> Erreur lors de l'enregistrement du fichier.</div>";
            }
        }
    }
    // ────────────────────────────────────────────────────────────────

    // Si ni upload ni URL saisi → on garde l'ancienne image de l'article
    if (empty($img))
        $img = 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800';

    // Mise à jour en BDD (seulement si pas d'erreur d'upload)
    if (empty($msg)) {
        $stmt = $conn->prepare("UPDATE articles SET title=?, content=?, category_id=?, image_url=? WHERE id=?");
        $stmt->bind_param("ssisi", $title, $content, $cat, $img, $id);
        if ($stmt->execute()) {
            $msg = "<div class='alert alert-success'><i class='fa-solid fa-check-double'></i> Votre article a été mis à jour avec succès.</div>";
        } else {
            $msg = "<div class='alert alert-error'><i class='fa-solid fa-circle-exclamation'></i> Erreur lors de la mise à jour.</div>";
        }
        $stmt->close();
    }
}

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$article = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$article) {
    header("Location: dashboard.php");
    exit();
}

require_once '../includes/header.php';
?>
<div class="admin-layout">
    <div class="admin-sidebar glass-card" style="align-self: flex-start; padding: 20px;">
        <h3
            style="margin-bottom: 20px; font-size: 1.2rem; display:flex; align-items:center; gap:10px; color: var(--primary);">
            <i class="fa-solid fa-screwdriver-wrench"></i> Administration</h3>
        <div class="admin-menu">
            <a href="dashboard.php" class="admin-menu-item"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="add_article.php" class="admin-menu-item"><i class="fa-solid fa-pen-to-square"></i> Nouvel
                Article</a>
            <a href="add_category.php" class="admin-menu-item"><i class="fa-solid fa-folder-plus"></i> Catégories</a>
        </div>
    </div>
    <div class="admin-main glass-card">
        <h2 style="margin-bottom: 20px;"><i class="fa-solid fa-pen-to-square text-primary"></i> Modifier l'article</h2>
        <?= $msg ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Titre de l'article</label>
                <input type="text" name="title" class="form-control" required
                    value="<?= htmlspecialchars($article['title']) ?>" style="font-size: 1.1rem; padding: 15px;">
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label class="form-label">Catégorie</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-folder text-muted"
                            style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%);"></i>
                        <select name="category_id" class="form-control" required
                            style="padding-left: 45px; cursor: pointer; appearance: none;">
                            <?php
                            $cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                            if ($cats && $cats->num_rows > 0) {
                                while ($c = $cats->fetch_assoc()) {
                                    $selected = ($c['id'] == $article['category_id']) ? 'selected' : '';
                                    echo "<option style='color:#000' value='{$c['id']}' $selected>" . htmlspecialchars($c['name']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Créez d'abord une catégorie !</option>";
                            }
                            ?>
                        </select>
                        <i class="fa-solid fa-chevron-down text-muted"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>
                    </div>
                </div>
                <div class="form-group" style="flex: 2; min-width: 300px;">
                    <label class="form-label">Image de couverture</label>

                    <!-- Aperçu de l'image actuelle -->
                    <?php if (!empty($article['image_url'])): ?>
                    <div style="margin-bottom:14px;">
                        <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:8px;">
                            <i class="fa-solid fa-image"></i> Aperçu de l'image actuelle :
                        </p>
                        <!-- Cadre de prévisualisation : fond sombre, image entière visible sans coupure -->
                        <div style="
                            background: rgba(0,0,0,0.3);
                            border: 2px solid rgba(79,70,229,0.35);
                            border-radius: 14px;
                            padding: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            min-height: 240px;
                            position: relative;
                            overflow: hidden;
                        ">
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" 
                                 id="preview-src" 
                                 style="
                                    max-width: 100%; 
                                    max-height: 280px; 
                                    width: auto;
                                    height: auto;
                                    object-fit: contain;
                                    border-radius: 8px;
                                    display: block;
                                 "
                            >
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Cadre vide (si aucune image actuelle) -->
                    <div id="img-preview" style="display:none; margin-bottom:14px;">
                        <div style="
                            background: rgba(0,0,0,0.3);
                            border: 2px solid rgba(79,70,229,0.35);
                            border-radius: 14px;
                            padding: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            min-height: 240px;
                        ">
                            <img id="preview-src" src="" style="
                                max-width: 100%; 
                                max-height: 280px; 
                                width: auto;
                                height: auto;
                                object-fit: contain;
                                border-radius: 8px;
                                display: block;
                            ">
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Tabs -->
                    <div style="display:flex; border-radius:10px; overflow:hidden; border: 1px solid var(--glass-border); margin-bottom: 12px;">
                        <button type="button" id="tab-upload" onclick="switchTab('upload')" style="flex:1; padding:8px; background: var(--primary); color:#fff; border:none; cursor:pointer; font-weight:600; font-size:0.85rem; transition:0.2s;">
                            <i class="fa-solid fa-upload"></i> Changer (PC)
                        </button>
                        <button type="button" id="tab-url" onclick="switchTab('url')" style="flex:1; padding:8px; background:transparent; color:var(--text-muted); border:none; cursor:pointer; font-size:0.85rem; transition:0.2s;">
                            <i class="fa-solid fa-link"></i> Lien URL
                        </button>
                        <button type="button" id="tab-keep" onclick="switchTab('keep')" style="flex:1; padding:8px; background:transparent; color:var(--text-muted); border:none; cursor:pointer; font-size:0.85rem; transition:0.2s;">
                            <i class="fa-solid fa-lock"></i> Garder
                        </button>
                    </div>

                    <!-- Zone upload PC -->
                    <div id="zone-upload">
                        <label for="image_file" style="
                            display:flex; flex-direction:column; align-items:center; justify-content:center;
                            border: 2px dashed rgba(79,70,229,0.4); border-radius:12px; padding:25px;
                            cursor:pointer; background:rgba(79,70,229,0.05); color:var(--text-muted);
                        " id="drop-label" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='rgba(79,70,229,0.4)'">
                            <i class="fa-solid fa-cloud-arrow-up" id="upload-icon" style="font-size:2rem; margin-bottom:10px; color:var(--primary);"></i>
                            <span id="upload-text" style="font-weight:600;">Cliquez ou déposez votre image ici</span>
                            <span style="font-size:0.78rem; margin-top:5px;">JPG, PNG, WebP, GIF · Max 5 Mo</span>
                        </label>
                        <input type="file" name="image_file" id="image_file" accept="image/*" style="display:none;" onchange="previewImage(this)">
                    </div>

                    <!-- Zone URL -->
                    <div id="zone-url" style="display:none;">
                        <div style="position: relative;">
                            <i class="fa-solid fa-image text-muted" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%);"></i>
                            <input type="url" name="image_url" id="image_url" class="form-control"
                                value="<?= htmlspecialchars($article['image_url']) ?>" style="padding-left: 45px;" placeholder="https://...">
                        </div>
                    </div>

                    <!-- Zone Garder (mode par défaut si image existante) -->
                    <div id="zone-keep" style="display:none;">
                        <input type="hidden" name="image_url" value="<?= htmlspecialchars($article['image_url']) ?>">
                        <p style="color: var(--text-muted); font-size:0.85rem; padding: 10px 0;">
                            <i class="fa-solid fa-circle-check" style="color:#10b981;"></i> L'image actuelle sera conservée.
                        </p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Contenu éditorial</label>
                <textarea name="content" class="form-control" rows="12" required
                    style="resize: vertical;"><?= htmlspecialchars($article['content']) ?></textarea>
            </div>

            <div style="text-align: right; margin-top: 30px;">
                <a href="dashboard.php" class="btn btn-outline" style="margin-right: 10px;">Annuler</a>
                <button class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 30px;"><i
                        class="fa-solid fa-save"></i> Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>

<script>
// Basculer entre Upload PC / Lien URL / Garder l'image actuelle
function switchTab(tab) {
    const zones   = { upload: document.getElementById('zone-upload'), url: document.getElementById('zone-url'), keep: document.getElementById('zone-keep') };
    const tabs    = { upload: document.getElementById('tab-upload'),  url: document.getElementById('tab-url'),  keep: document.getElementById('tab-keep') };

    // Cacher toutes les zones et réinitialiser les tabs
    Object.keys(zones).forEach(k => {
        if (zones[k]) zones[k].style.display = 'none';
        if (tabs[k]) { tabs[k].style.background = 'transparent'; tabs[k].style.color = 'var(--text-muted)'; }
    });

    // Afficher la zone active et mettre en valeur son tab
    if (zones[tab]) zones[tab].style.display = 'block';
    if (tabs[tab])  { tabs[tab].style.background = 'var(--primary)'; tabs[tab].style.color = '#fff'; }

    // Nettoyer les champs non actifs
    if (tab !== 'upload') { const f = document.getElementById('image_file'); if (f) f.value = ''; }
    if (tab !== 'url')    { const u = document.getElementById('image_url');  if (u && tab !== 'keep') {} }
}

// Prévisualiser l'image choisie depuis le PC
function previewImage(input) {
    const previewEl = document.getElementById('preview-src');
    const text      = document.getElementById('upload-text');
    const icon      = document.getElementById('upload-icon');
    // Afficher le cadre de prévisualisation s'il était caché
    const previewBox = document.getElementById('img-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewEl) {
                previewEl.src = e.target.result;
                // Afficher le cadre (si caché)
                if (previewBox) previewBox.style.display = 'block';
            }
            if (text) text.textContent = '✅ ' + input.files[0].name;
            if (icon) { icon.className = 'fa-solid fa-circle-check'; icon.style.color = '#10b981'; }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Init : activer le bon tab par défaut selon si une image existe
document.addEventListener('DOMContentLoaded', function() {
    // Si une image existe déjà → on part sur "Changer (PC)" par défaut
    switchTab('upload');

    // Prévisualiser en temps réel si on saisit un lien URL
    const urlInput = document.getElementById('image_url');
    if (urlInput) {
        urlInput.addEventListener('input', function() {
            const previewEl = document.getElementById('preview-src');
            if (previewEl && this.value) previewEl.src = this.value;
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>