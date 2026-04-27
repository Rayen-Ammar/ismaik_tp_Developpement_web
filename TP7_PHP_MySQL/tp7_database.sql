/*
 * Fichier: tp7_database.sql
 * Description: Ce script SQL contient les commandes pour créer la base de données 'tp7',
 *              ainsi que les tables 'utilisateurs', 'etudiants' et 'notes' conformément
 *              aux spécifications des Exercices 1 et 2 du TP7. Il inclut également
 *              l'insertion des données initiales requises.
 * Auteur: [Votre Nom]
 * Date: 11 avril 2026
 */

-- Création de la base de données 'tp7' si elle n'existe pas déjà.
-- Cela permet de s'assurer que le script peut être exécuté plusieurs fois sans erreur
-- si la base de données est déjà présente.
CREATE DATABASE IF NOT EXISTS tp7;

-- Sélection de la base de données 'tp7' pour que les commandes suivantes s'appliquent à celle-ci.
USE tp7;

-- Exercice 1: Création des tables

-- Table 'utilisateurs': Gère les informations d'authentification des utilisateurs.
-- id: Identifiant unique de l'utilisateur, auto-incrémenté et clé primaire.
-- username: Nom d'utilisateur pour la connexion, doit être unique.
-- password: Mot de passe de l'utilisateur.
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL -- Utilisation de VARCHAR(255) pour stocker des mots de passe hachés (bonne pratique de sécurité)
);

-- Table 'etudiants': Stocke les informations personnelles des étudiants.
-- id: Identifiant unique de l'étudiant, auto-incrémenté et clé primaire.
-- nom: Nom de l'étudiant.
-- prenom: Prénom de l'étudiant.
-- email: Adresse e-mail de l'étudiant, doit être unique.
CREATE TABLE IF NOT EXISTS etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Table 'notes': Enregistre les notes obtenues par les étudiants dans différentes matières.
-- id: Identifiant unique de la note, auto-incrémenté et clé primaire.
-- id_etudiant: Clé étrangère faisant référence à l'identifiant de l'étudiant dans la table 'etudiants'.
-- matiere: Nom de la matière pour laquelle la note est attribuée.
-- note: La note obtenue par l'étudiant (peut être un nombre décimal).
-- FOREIGN KEY (id_etudiant) REFERENCES etudiants(id): Définit la relation entre les tables 'notes' et 'etudiants'.
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT NOT NULL,
    matiere VARCHAR(50) NOT NULL,
    note FLOAT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id) ON DELETE CASCADE -- Si un étudiant est supprimé, ses notes le sont aussi.
);

-- Exercice 2: Insertion de données

-- Insertion d'un utilisateur 'admin' avec le mot de passe '1234'.
-- En production, le mot de passe devrait être haché avant l'insertion.
INSERT INTO utilisateurs (username, password) VALUES ('admin', '1234');

-- Insertion d'un étudiant 'Ali Ahmed' avec une adresse e-mail.
INSERT INTO etudiants (nom, prenom, email) VALUES ('Ahmed', 'Ali', 'ali.ahmed@example.com');

-- Insertion d'une note de 15 en 'Math' pour l'étudiant dont l'ID est 1 (Ali Ahmed).
INSERT INTO notes (id_etudiant, matiere, note) VALUES (1, 'Math', 15);
