<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 6 (POST)</title>
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
                <h2 class="card-title mb-0">Exercice 6 : Formulaire avec POST</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Comprendre comment récupérer des données soumises via un formulaire HTML en utilisant la méthode POST et ses avantages en termes de sécurité.</p>
                <hr>
                <h4>Formulaire :</h4>
                <form method="POST" action="exercice6.php" class="mb-4">
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Votre Prénom :</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prénom">
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>

                <h4>Résultat de l'exécution :</h4>
                <div class="alert alert-success" role="alert">
                    <?php
                        /**
                         * Exercice 6: Formulaire avec POST
                         * Objectif: Démontrer l'utilisation de la méthode POST pour la soumission de formulaires.
                         *
                         * La méthode POST envoie les données du formulaire dans le corps de la requête HTTP,
                         * ce qui les rend invisibles dans l'URL et plus sécurisées pour les données sensibles.
                         * La superglobale `$_POST` est un tableau associatif qui contient toutes les données envoyées par POST.
                         * `isset($_POST["prenom"])` vérifie si la clé 'prenom' existe dans le tableau `$_POST`.
                         * `htmlspecialchars()` est toujours recommandé pour prévenir les attaques XSS.
                         */
                        if (isset($_POST["prenom"])) {
                            // Récupère la valeur du champ 'prenom' et la nettoie
                            $prenom_saisi = htmlspecialchars($_POST["prenom"]);
                            echo "Bonjour, " . $prenom_saisi . " !";
                        } else {
                            echo "Veuillez entrer votre prénom dans le formulaire ci-dessus.";
                        }
                    ?>
                </div>
                <hr>
                <h4>Explication du code :</h4>
                <pre><code class="language-php">&lt;!-- Formulaire HTML --&gt;
&lt;form method="POST" action="exercice6.php"&gt;
    &lt;label for="prenom"&gt;Votre Prénom :&lt;/label&gt;
    &lt;input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom"&gt;
    &lt;button type="submit"&gt;Envoyer&lt;/button&gt;
&lt;/form&gt;

&lt;?php
    if (isset($_POST["prenom"])) { // Vérifie si le champ 'prenom' a été soumis via POST
        $prenom_saisi = htmlspecialchars($_POST["prenom"]); // Récupère et sécurise la valeur
        echo "Bonjour, " . $prenom_saisi . " !"; // Affiche le message de bienvenue
    } else {
        echo "Veuillez entrer votre prénom dans le formulaire ci-dessus.";
    }
?&gt;</code></pre>
                <p>Cet exercice met en évidence la méthode POST, qui est préférée pour l'envoi de données sensibles ou de grande taille, car les informations ne sont pas exposées dans l'URL. La superglobale <code>$_POST</code> est utilisée pour accéder aux données. Comme pour GET, la sécurisation des entrées utilisateur avec <code>htmlspecialchars()</code> est une bonne pratique essentielle.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
