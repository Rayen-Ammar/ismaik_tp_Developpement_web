CREATE DATABASE IF NOT EXISTS tp8_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tp8_cms;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TP9 - PARTIE 1 : Gestion des rôles utilisateurs
-- ============================================================
-- Si la colonne 'role' n'existe pas encore dans votre table :
-- ALTER TABLE users ADD role ENUM('admin', 'user') DEFAULT 'user';
--
-- Pour définir l'utilisateur id=1 comme administrateur :
-- UPDATE users SET role='admin' WHERE id=1;
-- ============================================================

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_url VARCHAR(500) DEFAULT 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=800',
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertion de l'Admin par défaut (pseudo: admin, mot de passe: admin)
INSERT IGNORE INTO users (username, password, role) VALUES ('admin', '$2y$10$NS2EUDfQUrUYCygpfL9zEu4h7DABP.zBdUVqGdT4jhNH3a2JsxADK', 'admin');

-- Insertion de catégories professionnelles
INSERT IGNORE INTO categories (name) VALUES ('Technologie'), ('Design Web'), ('Programmation Avancée'), ('Cybersécurité');

-- Insertion d'un article de démonstration avec une belle image
INSERT IGNORE INTO articles (title, content, category_id, image_url) VALUES 
('L\'avenir des Systèmes de Gestion de Contenu (CMS)', 'Ce CMS sur-mesure a été conçu avec une attention particulière aux détails pour garantir des performances optimales et une expérience utilisateur inégalée.\n\nProfitez d\'un design fluide avec le Glassmorphism, d\'interfaces animées et d\'une sécurité renforcée contre les injections SQL (via requêtes préparées).\n\nCette application est la preuve d\'un travail rigoureux et de haut niveau, prête pour les environnements de production les plus exigeants.', 1, 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800');
