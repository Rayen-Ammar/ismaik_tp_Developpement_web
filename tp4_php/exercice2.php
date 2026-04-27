<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 2</title>
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
                <h2 class="card-title mb-0">Exercice 2 : Variables en PHP</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Déclarer, assigner et afficher la valeur d'une variable en PHP.</p>
                <hr>
                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 2: Variables en PHP
                         * Objectif: Illustrer la déclaration et l'utilisation des variables.
                         *
                         * En PHP, les variables commencent toujours par le signe dollar ($).
                         * Elles sont utilisées pour stocker des informations qui peuvent être modifiées.
                         * L'opérateur `.` est utilisé pour la concaténation de chaînes de caractères.
                         */
                        $nom = "Ahmed"; // Déclaration et initialisation de la variable $nom avec la chaîne "Ahmed"
                        echo "Bonjour " . $nom; // Affichage de la chaîne "Bonjour " concaténée avec la valeur de $nom
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;?php
    $nom = "Ahmed"; // Déclare une variable nommée $nom et lui assigne la valeur "Ahmed"
    echo "Bonjour " . $nom; // Affiche la chaîne "Bonjour " suivie de la valeur de la variable $nom
?&gt;</code></pre>
                <p>Cet exercice démontre l'utilisation fondamentale des variables en PHP. Le signe dollar (<code>$</code>) est obligatoire pour toute variable. La concaténation de chaînes de caractères se fait avec l'opérateur point (<code>.</code>), ce qui permet de combiner du texte statique avec le contenu des variables.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
