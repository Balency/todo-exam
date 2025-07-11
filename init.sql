-- Création de la base
CREATE DATABASE IF NOT EXISTS todo_db;
USE todo_db;

-- Table des todos
DROP TABLE IF EXISTS todos;

CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    done BOOLEAN DEFAULT FALSE,
    secret_key VARCHAR(255) DEFAULT NULL;
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertion de todos publics et privés
INSERT INTO todos (title, description, done)
VALUES
("Préparer le cours", "Rédiger l'exercice sur les API REST", FALSE),
("Envoyer les mails", "Informer les étudiants du projet final", TRUE),
("Lire la doc PHP", "Lire la documentation officielle sur PDO", FALSE),
("Aller courir", "Jogging de 30 min", FALSE),
("Poster un article", "Publier un article sur les REST APIs", TRUE);
