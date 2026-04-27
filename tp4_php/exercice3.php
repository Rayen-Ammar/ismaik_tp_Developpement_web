<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 3</title>
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
                <h2 class="card-title mb-0">Exercice 3 : Calcul simple</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Effectuer des opérations arithmétiques de base en PHP et afficher le résultat.</p>
                <hr>
                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 3: Calcul simple
                         * Objectif: Démontrer les opérations arithmétiques en PHP.
                         *
                         * PHP supporte les opérateurs arithmétiques classiques (+, -, *, /).
                         * Les variables peuvent stocker des nombres et être utilisées dans des calculs.
                         */
                        $a = 10; // Déclaration et initialisation de la variable $a
                        $b = 5;  // Déclaration et initialisation de la variable $b
                        $resultat = $a + $b; // Effectue l'addition des valeurs de $a et $b et stocke le résultat dans $resultat
                        echo "Le résultat est : " . $resultat; // Affiche le résultat de l'opération
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;?php
    $a = 10; // Définit la première opérande
    $b = 5;  // Définit la seconde opérande
    $resultat = $a + $b; // Effectue l'addition
    echo "Le résultat est : " . $resultat; // Affiche le résultat
?&gt;</code></pre>
                <p>Cet exercice illustre comment PHP peut être utilisé pour des calculs numériques. Les variables <code>$a</code> et <code>$b</code> stockent des valeurs numériques, et l'opérateur <code>+</code> est utilisé pour effectuer une addition. Le résultat est ensuite stocké dans la variable <code>$resultat</code> et affiché. PHP gère automatiquement les types de données pour les opérations arithmétiques.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
