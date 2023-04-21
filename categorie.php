<!DOCTYPE html>
<html>
    <head>
        <title>Ajouter une auto</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="boite">
        <h2>Ajouter une catégorie</h2>
        <form method="post" action="categorie.php">
            <div class="champ">
                <label>Catégorie : </label>
                <input class="field" type="text" name="categorie" pattern="[A-Za-z -]{2,30}" required/>
            </div>
            <div class="champ center">
                <input class="btn" type="submit" name="ajouterCategorie" value="Ajouter" />
            </div>
        </form>
    </div>
    <?php
    include "connexion-pdo.php";
        if (isset($_POST["ajouterCategorie"])) {
            $categorie = "'".$_POST["categorie"]."'";

            try {
                $insert = "INSERT INTO categorie(nomCategorie)
                VALUES
                ($categorie)
                ";
                $dbco -> exec($insert);
            } catch (PDOException $e) {
                echo "Erreur : " . $e -> getMessage();
            } 
        }
?>
        <div class="boite">
        <h2>Ajouter un produit</h2>
        <form method="post" action="categorie.php">
            <div class="champ">
                <label>Produit : </label>
                <input class="field" type="text" name="produit" pattern="[A-Za-z -]{2,30}" required/>
            </div>
            <div class="champ">
                <label>Prix : </label>
                <input class="field" type="int" name="prix" required/>
            </div>
            <div class="champ">
                <label>Catégorie : </label>
                <select name="categorie">
                <?php
                    include "connexion-pdo.php";
                        try {
                            $selectCategorie = $dbco->prepare("SELECT nomCategorie FROM categorie
                            ");
                            $selectCategorie -> execute();
                            $resultatCategorie = $selectCategorie->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($resultatCategorie as $array) {
                                foreach ($array as $v) {
                                ?>
                                <option value="<?php echo($v)?>"><?php echo($v)?></option>
                                <?php
                            }
                        } 

                        } catch (PDOException $e) {
                        echo "Erreur : " . $e -> getMessage();

                    }
                ?>
                </select>
            </div>
            <div class="champ center">
                <input class="btn" type="submit" name="ajouterProduit" value="Ajouter" />
            </div>
        </form>
        <a href="affichage.php"><h3>Voir les produits</h3></a>
    </div>
    <?php
    include "connexion-pdo.php";
        if (isset($_POST["ajouterProduit"])) {
            $produit = "'".$_POST["produit"]."'";
            $prix = $_POST["prix"];
            $selCategorie = $_POST["categorie"];
            $idCategorieChoisi = 0;

            $findCategorie = $dbco->prepare("SELECT DISTINCT id
            FROM categorie
            WHERE nomCategorie = '$selCategorie'
            ");
            $findCategorie -> execute();
            $resCategorie = $findCategorie->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resCategorie as $array) {
                foreach ($array as $v) {
                $idCategorieChoisi = $v;
                } 
            }
            try {
                $insert = "INSERT INTO produit(nomProduit, prix, idCategorie)
                VALUES
                ($produit,$prix,$idCategorieChoisi)
                ";
                $dbco -> exec($insert);
            } catch (PDOException $e) {
                echo "Erreur : " . $e -> getMessage();
            } 

        }
?>
    </body>
</html> 