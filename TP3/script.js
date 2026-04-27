/**
 * Application de Gestion Étudiante - TP3 JavaScript
 * Date : 17 Février 2026
 */

// --- Initialisation du script ---
// Affiche un message de confirmation dans la console du navigateur au chargement du script
console.log("TP3 JavaScript chargé");

// --- Gestion de l'affichage du message de bienvenue ---
// Sélection de l'élément bouton par son identifiant unique 'btnTest'
const btnTest = document.getElementById("btnTest");
// Sélection de l'élément paragraphe par son identifiant unique 'resultat'
const resultat = document.getElementById("resultat");

// Ajout d'un écouteur d'événement pour détecter le clic sur le bouton 'btnTest'
btnTest.addEventListener("click", function() {
    // Modification du contenu textuel du paragraphe pour afficher le message de bienvenue
    resultat.textContent = "Bienvenue en TP3";
});

// --- Gestion de la lecture rapide du champ de texte ---
// Sélection de l'élément d'entrée de texte par son identifiant unique 'nom'
const inputNom = document.getElementById("nom");
// Sélection de l'élément bouton par son identifiant unique 'btnLire'
const btnLire = document.getElementById("btnLire");

// Ajout d'un écouteur d'événement pour détecter le clic sur le bouton 'btnLire'
btnLire.addEventListener("click", function() {
    // Récupération de la valeur saisie dans le champ de texte
    const valeurNom = inputNom.value;
    // Affichage de la valeur récupérée dans la console du navigateur
    console.log("Valeur saisie : " + valeurNom);
});

// --- Gestion du formulaire d'inscription des étudiants ---
// Sélection de l'élément formulaire par son identifiant unique 'formEtudiant'
const formEtudiant = document.getElementById("formEtudiant");
// Sélection du champ de saisie du nom de l'étudiant
const inputNomEtudiant = document.getElementById("inputNom");
// Sélection du champ de saisie du prénom de l'étudiant
const inputPrenomEtudiant = document.getElementById("inputPrenom");
// Sélection de la liste non ordonnée qui contiendra les étudiants
const listeEtudiants = document.getElementById("listeEtudiants");

// Ajout d'un écouteur d'événement pour gérer la soumission du formulaire
formEtudiant.addEventListener("submit", function(event) {
    // Empêche le comportement par défaut du formulaire qui rechargerait la page
    event.preventDefault();

    // Récupération et nettoyage des valeurs saisies (suppression des espaces inutiles)
    const nom = inputNomEtudiant.value.trim();
    const prenom = inputPrenomEtudiant.value.trim();

    // --- Validation des données saisies ---
    // Vérification si l'un des champs est vide après nettoyage
    if (nom === "" || prenom === "") {
        // Affiche une alerte si les champs obligatoires ne sont pas remplis
        alert("Champs obligatoires");
        // Arrête l'exécution de la fonction pour ne pas ajouter d'étudiant vide
        return;
    }

    // Affichage des valeurs validées dans la console pour confirmation
    console.log("Ajout de l'étudiant : " + nom + " " + prenom);

    // --- Création dynamique de l'élément de liste ---
    // Création d'un nouvel élément de liste <li>
    const nouvelEtudiant = document.createElement("li");
    // Définition du contenu textuel de l'élément avec le format "Nom - Prénom"
    nouvelEtudiant.textContent = nom + " - " + prenom;

    // --- Gestion de la suppression (Option Bonus intégrée) ---
    // Ajout d'un écouteur d'événement sur l'élément de liste pour permettre sa suppression au clic
    nouvelEtudiant.addEventListener("click", function() {
        // Suppression de l'élément lui-même de l'arborescence du document
        nouvelEtudiant.remove();
        // Notification de la suppression dans la console
        console.log("Étudiant supprimé de la liste");
    });

    // Ajout du nouvel élément <li> à la fin de la liste <ul> existante
    listeEtudiants.appendChild(nouvelEtudiant);

    // Réinitialisation des champs du formulaire pour une nouvelle saisie
    formEtudiant.reset();
    // Remise du focus sur le premier champ pour améliorer l'expérience utilisateur
    inputNomEtudiant.focus();
});
