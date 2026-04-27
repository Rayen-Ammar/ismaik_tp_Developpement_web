<?php
/*
 * ============================================================
 *  TP5 : Tableaux et Boucles en PHP
 *  ISMAI Kairouan — Département Informatique
 *  Matière : Programmation Web
 *  Enseignant : Hédi Nsibi | Année : 2025/2026
 * ============================================================
 */

/* ────────────────────────────────────────────────────────────
 *  EXERCICE 2 : Initialisation et récupération des données
 * ──────────────────────────────────────────────────────────── */

$nom      = "";       // Nom de l'étudiant (vide par défaut)
$note1    = "";       // Note 1 (vide par défaut)
$note2    = "";       // Note 2 (vide par défaut)
$note3    = "";       // Note 3 (vide par défaut)
$notes    = [];       // Tableau vide qui contiendra les 3 notes
$soumis   = false;    // Indique si le formulaire a été soumis
$moyenne  = 0;        // Moyenne calculée (0 par défaut)

/* Vérifier si la requête HTTP est de type POST
   (c'est-à-dire si le formulaire a bien été soumis) */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $soumis = true;  // Le formulaire a été soumis

    /* Récupérer le nom depuis les données envoyées en POST
       htmlspecialchars() protège contre les attaques XSS */
    $nom   = htmlspecialchars(trim($_POST["nom"]));

    /* Récupérer les 3 notes et les convertir en nombres décimaux */
    $note1 = (float) $_POST["note1"];
    $note2 = (float) $_POST["note2"];
    $note3 = (float) $_POST["note3"];

    /* ────────────────────────────────────────────────────────
     *  EXERCICE 3 : Créer un tableau PHP avec les 3 notes
     * ──────────────────────────────────────────────────────── */

    $notes   = [];          // Créer un tableau vide
    $notes[] = $note1;      // Ajouter la note 1 au tableau
    $notes[] = $note2;      // Ajouter la note 2 au tableau
    $notes[] = $note3;      // Ajouter la note 3 au tableau

    /* ────────────────────────────────────────────────────────
     *  EXERCICE 5 : Calcul de la moyenne
     * ──────────────────────────────────────────────────────── */

    $somme   = array_sum($notes);   // Calculer la somme de toutes les notes
    $nombre  = count($notes);       // Compter le nombre d'éléments dans le tableau
    $moyenne = $somme / $nombre;    // Diviser la somme par le nombre pour avoir la moyenne
}

/* ────────────────────────────────────────────────────────────
 *  Fonction utilitaire : initiales de l'étudiant (pour avatar)
 * ──────────────────────────────────────────────────────────── */
function getInitiales(string $nom): string {
    $mots = explode(" ", strtoupper(trim($nom)));   // Découper le nom en mots
    $init = "";
    foreach ($mots as $mot) {                       // Pour chaque mot
        if ($mot !== "") $init .= $mot[0];          // Prendre la première lettre
        if (strlen($init) >= 2) break;              // S'arrêter après 2 lettres
    }
    return $init ?: "?";    // Retourner les initiales ou "?" si vide
}

/* ────────────────────────────────────────────────────────────
 *  Fonction utilitaire : couleur de la note (rouge/orange/vert)
 * ──────────────────────────────────────────────────────────── */
function couleurNote(float $note): string {
    if ($note >= 14) return "#16a34a";      // Très bien → vert
    if ($note >= 10) return "#2563eb";      // Bien      → bleu
    return "#dc2626";                        // Insuffisant → rouge
}
?>
<!DOCTYPE html>
<!-- Déclaration de la langue française -->
<html lang="fr">
<head>

    <!-- Encodage des caractères Unicode -->
    <meta charset="UTF-8">

    <!-- Affichage responsive sur mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Titre affiché dans l'onglet du navigateur -->
    <title>TP5 — Tableaux &amp; Boucles PHP</title>

    <!-- Lien vers la feuille de style CSS externe -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<!-- ═══════════════════════════════════════════════════════════
     CONTENEUR PRINCIPAL
════════════════════════════════════════════════════════════ -->
<div class="container">

    <!-- ── EN-TÊTE DE LA PAGE ─────────────────────────────── -->
    <header class="page-header">
        <span class="tp-badge">TP 5 &nbsp;·&nbsp; 2025 / 2026</span>
        <h1>Tableaux &amp; Boucles en PHP</h1>
        <p>ISMAI Kairouan &nbsp;·&nbsp; Programmation Web &nbsp;·&nbsp; Rayen Ammar</p>
    </header>

    <!-- ═══════════════════════════════════════════════════════
         EXERCICE 1 : Formulaire HTML
    ════════════════════════════════════════════════════════ -->
    <section class="card">

        <!-- Titre de la carte -->
        <div class="card-header">
            <span class="ex-num">1</span>
            Formulaire Étudiant
        </div>

        <div class="card-body">

            <!-- Formulaire avec méthode POST : les données seront
                 envoyées au même fichier (action vide = auto-envoi) -->
            <form method="POST" action="">

                <!-- ── Champ Nom ──────────────────────────── -->
                <div class="form-group">
                    <label for="nom">
                        Nom et Prénom
                        <span class="required">*</span>
                    </label>
                    <!-- type="text" pour le nom | value conserve la valeur après soumission -->
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        placeholder="Ex : Ahmed Ben Ali"
                        value="<?php echo $nom; ?>"
                        required>
                </div>

                <!-- ── Champ Notes (grille 3 colonnes) ───── -->
                <div class="form-group">
                    <label>Notes <span class="required">*</span></label>

                    <div class="notes-grid">

                        <!-- Note 1 -->
                        <div>
                            <label for="note1" style="font-size:12px;font-weight:500;color:#64748b;">Note 1</label>
                            <!-- type="number" : saisie numérique | min et max : valeurs acceptées -->
                            <input
                                type="number"
                                id="note1"
                                name="note1"
                                placeholder="0 – 20"
                                min="0" max="20" step="0.5"
                                value="<?php echo $note1; ?>"
                                required>
                        </div>

                        <!-- Note 2 -->
                        <div>
                            <label for="note2" style="font-size:12px;font-weight:500;color:#64748b;">Note 2</label>
                            <input
                                type="number"
                                id="note2"
                                name="note2"
                                placeholder="0 – 20"
                                min="0" max="20" step="0.5"
                                value="<?php echo $note2; ?>"
                                required>
                        </div>

                        <!-- Note 3 -->
                        <div>
                            <label for="note3" style="font-size:12px;font-weight:500;color:#64748b;">Note 3</label>
                            <input
                                type="number"
                                id="note3"
                                name="note3"
                                placeholder="0 – 20"
                                min="0" max="20" step="0.5"
                                value="<?php echo $note3; ?>"
                                required>
                        </div>

                    </div><!-- fin .notes-grid -->
                </div><!-- fin .form-group notes -->

                <!-- ── Bouton de soumission ──────────────── -->
                <button type="submit" class="btn-submit">Valider</button>

            </form><!-- fin du formulaire -->

        </div><!-- fin .card-body -->
    </section><!-- fin exercice 1 -->


    <!-- ═══════════════════════════════════════════════════════
         RÉSULTATS : affichés uniquement si le formulaire a été soumis
    ════════════════════════════════════════════════════════ -->
    <?php if ($soumis) : ?>

    <div class="results-section">

        <!-- ── EXERCICE 2 : Affichage du nom et des notes récupérées ─ -->
        <section class="card">

            <div class="card-header">
                <span class="ex-num">2</span>
                Données Récupérées
            </div>

            <div class="card-body">

                <!-- Bloc info étudiant avec avatar initiales -->
                <div class="student-info">
                    <!-- Avatar avec les initiales du nom -->
                    <div class="student-avatar">
                        <?php echo getInitiales($nom); ?>
                    </div>
                    <!-- Nom de l'étudiant -->
                    <div class="student-name">
                        <?php echo $nom; ?>
                        <small>Étudiant — Licence Informatique</small>
                    </div>
                </div>

                <!-- ── EXERCICE 4 : Boucle foreach pour afficher les notes ─ -->
                <div class="notes-list">
                    <?php
                    $i = 1;  // Compteur pour numéroter les notes

                    /* foreach parcourt chaque élément du tableau $notes.
                       $note prend la valeur de chaque note à chaque itération */
                    foreach ($notes as $note) :
                        /* Calculer la largeur de la barre en % (note / 20 * 100) */
                        $pct = ($note / 20) * 100;
                    ?>
                        <!-- Carte pour la note <?php echo $i; ?> -->
                        <div class="note-card">

                            <!-- Label de la note -->
                            <div class="note-label">Note <?php echo $i; ?></div>

                            <!-- Valeur numérique de la note -->
                            <div class="note-value" style="color:<?php echo couleurNote($note); ?>">
                                <?php echo $note; ?>
                                <span class="note-max">/20</span>
                            </div>

                            <!-- Barre de progression proportionnelle à la note -->
                            <div class="note-bar">
                                <div class="note-bar-fill"
                                     style="width:<?php echo $pct; ?>%;
                                            background: <?php echo couleurNote($note); ?>;">
                                </div>
                            </div>

                        </div><!-- fin note-card -->

                    <?php
                        $i++;  // Incrémenter le compteur de notes
                    endforeach;
                    ?>
                </div><!-- fin .notes-list -->

            </div><!-- fin .card-body -->
        </section>


        <!-- ── EXERCICE 5 & 6 : Moyenne + Verdict ─────────────────── -->
        <section class="card">

            <div class="card-header">
                <span class="ex-num">5</span>
                Résultat Final
            </div>

            <div class="card-body">

                <!-- Bloc de la moyenne calculée -->
                <div class="moyenne-block">
                    <div>
                        <div class="moyenne-label">Moyenne générale</div>
                        <!-- Afficher la moyenne arrondie à 2 décimales avec round() -->
                        <div class="moyenne-value">
                            <?php echo round($moyenne, 2); ?>
                            <small> / 20</small>
                        </div>
                    </div>
                    <div style="font-size:13px; color:#93c5fd; text-align:right;">
                        <!-- Rappel de la formule utilisée -->
                        array_sum() / count()<br>
                        <span style="font-size:11px; opacity:0.7;">
                            <?php echo $note1; ?> + <?php echo $note2; ?> + <?php echo $note3; ?>
                            = <?php echo array_sum($notes); ?>
                        </span>
                    </div>
                </div>

                <!-- ── EXERCICE 6 : Condition Admis / Ajourné ──────── -->
                <?php
                /* Vérifier si la moyenne est supérieure ou égale à 10 */
                if ($moyenne >= 10) :
                ?>
                    <!-- Verdict ADMIS : affiché en vert -->
                    <div class="verdict admis">
                        <div class="verdict-icon">✅</div>
                        <div class="verdict-text">
                            Admis
                            <small>Moyenne ≥ 10 — Félicitations !</small>
                        </div>
                    </div>

                <?php else : ?>

                    <!-- Verdict AJOURNÉ : affiché en rouge -->
                    <div class="verdict ajourne">
                        <div class="verdict-icon">❌</div>
                        <div class="verdict-text">
                            Ajourné
                            <small>Moyenne &lt; 10 — Bon courage !</small>
                        </div>
                    </div>

                <?php endif; /* fin de la condition moyenne */ ?>

            </div><!-- fin .card-body -->
        </section>

    </div><!-- fin .results-section -->

    <?php endif; /* fin du if $soumis */ ?>


    <!-- ── PIED DE PAGE ──────────────────────────────────────── -->
    <footer class="page-footer">
        TP5 — Tableaux &amp; Boucles en PHP &nbsp;·&nbsp;
        ISMAI Kairouan &nbsp;·&nbsp; Rayen Ammar &nbsp;·&nbsp; 2025/2026
    </footer>

</div><!-- fin .container -->

</body>
</html>
