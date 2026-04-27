<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 4</title>
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
                <h2 class="card-title mb-0">Exercice 4 : Condition (if)</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Découvrir la structure conditionnelle <code>if-else</code> en PHP pour exécuter du code en fonction d'une condition.</p>
                <hr>
                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 4: Condition (if)
                         * Objectif: Démontrer l'utilisation des structures conditionnelles.
                         *
                         * La structure `if` permet d'exécuter un bloc de code si une condition est vraie.
                         * La structure `else` permet d'exécuter un autre bloc de code si la condition est fausse.
                         * Les opérateurs de comparaison comme `>=` (supérieur ou égal) sont utilisés pour évaluer les conditions.
                         */
                        $age = 18; // Déclaration et initialisation de la variable $age

                        // Vérifie si l'âge est supérieur ou égal à 18
                        if ($age >= 18) {
                            echo "Vous êtes majeur."; // Ce message s'affiche si la condition est vraie
                        } else {
                            echo "Vous êtes mineur."; // Ce message s'affiche si la condition est fausse
                        }
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;?php
    $age = 18; // Définit l'âge à tester

    if ($age >= 18) { // Si l'âge est supérieur ou égal à 18
        echo "Vous êtes majeur."; // Affiche ce message
    } else { // Sinon (si l'âge est inférieur à 18)
        echo "Vous êtes mineur."; // Affiche ce message
    }
?&gt;</code></pre>
                <p>Cet exercice introduit les structures de contrôle conditionnelles, essentielles pour la logique de programmation. Le bloc <code>if</code> évalue une expression booléenne ; si elle est vraie, le code à l'intérieur est exécuté. Le bloc <code>else</code> est optionnel et s'exécute si la condition du <code>if</code> est fausse. Vous pouvez modifier la valeur de <code>$age</code> dans le code pour observer les différents résultats.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
