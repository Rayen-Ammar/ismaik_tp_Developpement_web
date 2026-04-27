-- ==========================================================
-- SCRIPT DE CRÉATION DE LA BASE DE DONNÉES
-- Projet : Gestion des Étudiants (TP6)
-- Auteur : ammar rayen
-- ==========================================================

-- Création de la base de données si elle n'existe pas
CREATE DATABASE IF NOT EXISTS gestion_etudiants;

-- Sélection de la base de données pour les opérations suivantes
USE gestion_etudiants;

-- Création de la table 'etudiants' selon les spécifications du TP6
-- Cette table stocke les informations personnelles et les notes des étudiants
CREATE TABLE IF NOT EXISTS etudiants (
    -- Identifiant unique auto-incrémenté pour chaque étudiant
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- Nom de l'étudiant (maximum 50 caractères)
    nom VARCHAR(50) NOT NULL,
    
    -- Prénom de l'étudiant (maximum 50 caractères)
    prenom VARCHAR(50) NOT NULL,
    
    -- Adresse email (maximum 100 caractères)
    email VARCHAR(100) NOT NULL,
    
    -- Note 1 (nombre flottant)
    note1 FLOAT NOT NULL,
    
    -- Note 2 (nombre flottant)
    note2 FLOAT NOT NULL,
    
    -- Note 3 (nombre flottant)
    note3 FLOAT NOT NULL,
    
    -- Moyenne calculée des trois notes
    moyenne FLOAT NOT NULL,
    
    -- Date d'enregistrement (optionnel mais recommandé pour un projet pro)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
