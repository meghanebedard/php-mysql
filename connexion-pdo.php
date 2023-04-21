<?php
$servername = "localhost";
$username = "alfy";
$password = "nufhig-Cepxob-jenzu1";
$port = 8889;

try{ 
    $dbco = new PDO("mysql:host=$servername;port=$port", $username, $password);
    $dbco -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $createdb = "CREATE DATABASE IF NOT EXISTS Boutique";
    $dbco -> exec($createdb);

} catch (PDOException$e) {
    echo "Erreur : " . $e -> getMessage();
}

$dbname = "Boutique";

try {
    $dbco = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $dbco -> setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $createCategorie = "CREATE TABLE IF NOT EXISTS categorie(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nomCategorie VARCHAR(30) NOT NULL
        )";
    $dbco -> exec($createCategorie);
    $createProduit = "CREATE TABLE IF NOT EXISTS produit(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nomProduit VARCHAR(30) NOT NULL,
        prix DOUBLE NOT NULL,
        idCategorie INT  NOT NULL,
        FOREIGN KEY (idCategorie) REFERENCES categorie(id)
        )";
    $dbco -> exec($createProduit);
} catch (PDOException $e) {
    echo "Erreur : " . $e -> getMessage();
}
?>