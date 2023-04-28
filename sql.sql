DROP DATABASE IF EXISTS Boutique;
CREATE DATABASE Veille;
USE Veille;

CREATE TABLE sources(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nomSource VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE languages(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nomLanguage VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE resultats(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        date VARCHAR(30) NOT NULL,
        idSource INT NOT NULL,
        FOREIGN KEY (idSource) REFERENCES sources(id),
        auteur VARCHAR(30) NOT NULL,
        idLanguage INT NOT NULL,
        FOREIGN KEY (idLanguage) REFERENCES languages(id),
        evaluation INT  NOT NULL,
        resume VARCHAR(300) NOT NULL
);