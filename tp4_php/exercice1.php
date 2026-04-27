<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 1</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">TP4 PHP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="exercice1.php">Exercice 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exercice2.php">Exercice 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exercice3.php">Exercice 3</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exercice4.php">Exercice 4</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exercice5.php">Exercice 5 (GET)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exercice6.php">Exercice 6 (POST)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="etudiant.php">Exercice 7 (Mini-App)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2 class="card-title mb-0">Exercice 1 : Premier script PHP</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Comprendre la structure de base d'un script PHP et l'affichage de texte.</p>
                <hr>
                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 1: Premier script PHP
                         * Objectif: Afficher un message simple en utilisant la fonction `echo`.
                         *
                         * Le code PHP est toujours encadré par les balises `<?php` et `?>`.
                         * La fonction `echo` est utilisée pour envoyer du texte au navigateur.
                         * Chaque instruction PHP se termine par un point-virgule `;`.
                         */
                        echo "Bonjour en PHP !";
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;?php
    // Début du bloc de code PHP
    echo "Bonjour en PHP !"; // Utilisation de la fonction echo pour afficher la chaîne de caractères
?&gt;</code></pre>
                <p>Ce script PHP très simple illustre comment intégrer du code PHP dans une page HTML. La balise <code>&lt;?php ?&gt;</code> délimite le bloc de code PHP. La commande <code>echo</code> est fondamentale pour afficher du contenu dynamique ou statique sur la page web.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
