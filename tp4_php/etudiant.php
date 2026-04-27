<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP4 PHP - Exercice 7 (Mini-Application)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .form-container { background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .result-section { margin-top: 30px; padding: 20px; border-radius: 8px; background-color: #e9ecef; border: 1px solid #dee2e6; }
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
                <h2 class="card-title mb-0">Exercice 7 : Mini-Application (Gestion Étudiant)</h2>
            </div>
            <div class="card-body">
                <p class="card-text"><strong>Objectif :</strong> Créer un formulaire complet pour la saisie des informations d'un étudiant, valider les données, et afficher un compte rendu détaillé avec le statut (majeur/mineur).</p>
                <hr>

                <div class="form-container">
                    <h4 class="mb-4">Formulaire d'Inscription Étudiant</h4>
                    <?php
                        /**
                         * Exercice 7: Mini-Application (Gestion Étudiant)
                         * Objectif: Développer un formulaire complet avec validation et affichage conditionnel.
                         *
                         * Ce script gère la soumission d'un formulaire via la méthode POST.
                         * Il inclut des validations pour s'assurer que tous les champs requis sont remplis.
                         * Les données sont nettoyées avec `htmlspecialchars()` pour prévenir les attaques XSS.
                         * Un message d'erreur ou de succès est affiché en fonction de la validation et de l'âge de l'étudiant.
                         */

                        // Initialisation des variables pour stocker les valeurs du formulaire et les messages
                        $nom = $prenom = $email = $age = '';
                        $message_resultat = '';
                        $erreurs = []; // Tableau pour stocker les messages d'erreur

                        // Vérifie si le formulaire a été soumis via la méthode POST
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Récupération et nettoyage des données du formulaire
                            $nom = isset($_POST["nom"]) ? htmlspecialchars(trim($_POST["nom"])) : '';
                            $prenom = isset($_POST["prenom"]) ? htmlspecialchars(trim($_POST["prenom"])) : '';
                            $email = isset($_POST["email"]) ? htmlspecialchars(trim($_POST["email"])) : '';
                            $age = isset($_POST["age"]) ? htmlspecialchars(trim($_POST["age"])) : '';

                            // --- Validation des champs ---
                            if (empty($nom)) {
                                $erreurs[] = "Le champ 'Nom' est obligatoire.";
                            }
                            if (empty($prenom)) {
                                $erreurs[] = "Le champ 'Prénom' est obligatoire.";
                            }
                            if (empty($email)) {
                                $erreurs[] = "Le champ 'Email' est obligatoire.";
                            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validation du format de l'email
                                $erreurs[] = "L'adresse email n'est pas valide.";
                            }
                            if (empty($age)) {
                                $erreurs[] = "Le champ 'Âge' est obligatoire.";
                            } elseif (!is_numeric($age) || $age < 1 || $age > 120) { // Validation de l'âge (numérique, entre 1 et 120)
                                $erreurs[] = "L'âge doit être un nombre valide entre 1 et 120.";
                            }

                            // Si aucune erreur n'est détectée, traiter les données
                            if (empty($erreurs)) {
                                $message_resultat .= "<h5 class='text-primary'>Informations de l'étudiant :</h5>";
                                $message_resultat .= "<p><strong>Nom :</strong> " . $nom . "</p>";
                                $message_resultat .= "<p><strong>Prénom :</strong> " . $prenom . "</p>";
                                $message_resultat .= "<p><strong>Email :</strong> " . $email . "</p>";
                                $message_resultat .= "<p><strong>Âge :</strong> " . $age . " ans</p>";

                                // Détermination du statut (majeur/mineur)
                                if ($age < 18) {
                                    $message_resultat .= "<p class='text-danger'><strong>Statut :</strong> Étudiant mineur</p>";
                                } else {
                                    $message_resultat .= "<p class='text-success'><strong>Statut :</strong> Étudiant majeur</p>";
                                }
                            } else {
                                // Afficher les erreurs si le formulaire n'est pas valide
                                $message_resultat .= "<div class='alert alert-danger'>";
                                foreach ($erreurs as $erreur) {
                                    $message_resultat .= "<p class='mb-0'>" . $erreur . "</p>";
                                }
                                $message_resultat .= "</div>";
                            }
                        }
                    ?>

                    <form method="POST" action="etudiant.php" novalidate> <!-- novalidate pour gérer la validation côté serveur -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom :</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom :</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Âge :</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?php echo $age; ?>" min="1" max="120" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>

                <?php
                    // Affichage des résultats ou des erreurs après soumission
                    if (!empty($message_resultat)) {
                        echo "<div class='result-section mt-4'>" . $message_resultat . "</div>";
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
