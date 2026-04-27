<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 5 (GET)</title>
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
                <h2 class="card-title mb-0">Exercice 5 : Formulaire simple (GET)</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Comprendre comment récupérer des données soumises via un formulaire HTML en utilisant la méthode GET.</p>
                <hr>
                <h4>Formulaire :</h4>
                <form method="GET" action="exercice5.php" class="mb-4">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Votre Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom">
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>

                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 5: Formulaire simple (GET)
                         * Objectif: Récupérer et afficher une valeur envoyée par un formulaire via la méthode GET.
                         *
                         * La méthode GET envoie les données du formulaire dans l'URL sous forme de paires clé-valeur.
                         * La superglobale `$_GET` est un tableau associatif qui contient toutes les données envoyées par GET.
                         * `isset($_GET['nom'])` vérifie si la clé 'nom' existe dans le tableau `$_GET`, c'est-à-dire si le champ a été soumis.
                         * `htmlspecialchars()` est utilisé pour prévenir les attaques XSS en convertissant les caractères spéciaux en entités HTML.
                         */
                        if (isset($_GET["nom"])) {
                            // Récupère la valeur du champ 'nom' et la nettoie pour des raisons de sécurité
                            $nom_saisi = htmlspecialchars($_GET["nom"]);
                            echo "Bonjour, " . $nom_saisi . " !";
                        } else {
                            echo "Veuillez entrer votre nom dans le formulaire ci-dessus.";
                        }
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;!-- Formulaire HTML --&gt;
&lt;form method="GET" action="exercice5.php"&gt;
    &lt;label for="nom"&gt;Votre Nom :&lt;/label&gt;
    &lt;input type="text" id="nom" name="nom" placeholder="Entrez votre nom"&gt;
    &lt;button type="submit"&gt;Envoyer&lt;/button&gt;
&lt;/form&gt;

&lt;?php
    if (isset($_GET["nom"])) { // Vérifie si le champ 'nom' a été soumis via GET
        $nom_saisi = htmlspecialchars($_GET["nom"]); // Récupère et sécurise la valeur
        echo "Bonjour, " . $nom_saisi . " !"; // Affiche le message de bienvenue
    } else {
        echo "Veuillez entrer votre nom dans le formulaire ci-dessus.";
    }
?&gt;</code></pre>
                <p>Cet exercice illustre l'utilisation de la méthode GET pour la soumission de formulaires. Les données sont ajoutées à l'URL, ce qui les rend visibles. La superglobale <code>$_GET</code> permet d'accéder à ces données côté serveur. Il est crucial d'utiliser <code>htmlspecialchars()</code> pour échapper les caractères spéciaux et prévenir les vulnérabilités de sécurité comme les attaques XSS.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
