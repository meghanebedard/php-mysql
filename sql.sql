DROP DATABASE IF EXISTS Boutique;
CREATE DATABASE Boutique;
USE Boutique;

CREATE TABLE categorie(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nomCategorie VARCHAR(30) NOT NULL
);
CREATE TABLE produit(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nomProduit VARCHAR(30) NOT NULL,
        prix DOUBLE NOT NULL,
        idCategorie INT  NOT NULL,
        FOREIGN KEY (idCategorie) REFERENCES categorie(id)
);