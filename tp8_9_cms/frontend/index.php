<?php 
/*
 * FICHIER : frontend/index.php
 * RÔLE : Page d'accueil publique du site (Vitrine principale).
 * Ce script se connecte à la base de données, récupère tous les articles avec
 * leurs catégories jointes, et les affiche sous forme de cartes cliquables.
 */

// Import de l'en-tête (Navbar + base du code HTML)
require_once '../includes/header.php'; 
?>

<!-- Titre principal de la page d'accueil avec effet de dégradé de texte (CSS inline) -->
<div style="text-align: center; margin-bottom: 50px;">
    <h1 style="font-size: 3.5rem; margin-bottom: 20px; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Actualités & Découvertes</h1>
    <p style="font-size: 1.2rem; color: var(--text-muted); max-width: 600px; margin: 0 auto;">Explorez nos derniers articles soigneusement rédigés par notre équipe d'experts tech.</p>
</div>

<!-- Grille CSS pour aligner proprement les articles -->
<div class="articles-grid">
    <?php
    // 1. Requête SQL complexe : Jointure (LEFT JOIN) entre la table `articles` et la table `categories`
    // Objectif : Récupérer le contenu des articles ET le Nom de leur catégorie associée.
    // ORDER BY created_at DESC : On affiche les plus récents en premier.
    $sql = "SELECT articles.*, categories.name as cat_name FROM articles LEFT JOIN categories ON articles.category_id = categories.id ORDER BY articles.created_at DESC";
    $result = $conn->query($sql);
    
    // 2. Si on a trouvé au moins un article dans la base de données
    if ($result && $result->num_rows > 0) {
        // 3. Boucle WHILE : Pour chaque ligne (article) retournée par MySQL
        while($row = $result->fetch_assoc()) {
            // Formatage de la date SQL (Y-m-d H:i:s) en une belle date lisible
            $date = new DateTime($row['created_at']);
            
            // On vérifie si y a une image, sinon on met l'image de décoration par défaut d'Unsplash
            $img = $row['image_url'] ? htmlspecialchars($row['image_url']) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800';
            
            // 4. Génération du HTML (Carte de l'article avec lien vers article.php)
            echo "<a href='article.php?id={$row['id']}' class='article-card glass-card' style='padding: 15px;'>";
            echo "<div style='overflow:hidden; border-radius:12px;'><img src='{$img}' class='article-img'></div>";
            echo "<div style='padding: 10px 5px 0;'>";
            // Affichage de la catégorie ou d'une valeur par défaut s'il n'y en a pas
            echo "<span class='article-cat'><i class='fa-solid fa-tag'></i> " . htmlspecialchars($row['cat_name'] ?? 'Non catégorisé') . "</span>";
            echo "<h3 class='article-title'>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<div class='article-meta'><span title='Date de publication'><i class='fa-regular fa-clock'></i> " . $date->format('d M. Y') . "</span></div>";
            echo "</div></a>";
        }
    } else {
        // Cas où la table articles est totalement vide
        echo "<div class='glass-card' style='grid-column: 1 / -1; text-align:center;'><p><i class='fa-solid fa-ghost text-muted' style='font-size: 3rem; margin-bottom: 20px; display:block;'></i> Aucun article disponible pour le moment.</p></div>";
    }
    ?>
</div>

<!-- Import du pied de page -->
<?php require_once '../includes/footer.php'; ?>
