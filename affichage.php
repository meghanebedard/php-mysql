<!DOCTYPE html>
<html>
    <head>
        <title>Affichage</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="boite">
        <h2>Voici l'inventaire du produit</h2>
        <table>
            <thead>
                <th>Nom du produit</th>
                <th>Prix du produit</th>
                <th>Catégorie du produit</th>
            </thead>
            <tbody>
                <?php
                include "connexion-pdo.php";
                $afficher = $dbco->prepare(
                    "SELECT p.nomProduit, p.prix, c.nomCategorie
                    FROM produit AS p
                    INNER JOIN categorie AS c
                    ON p.idCategorie = c.id
                    ORDER BY p.nomProduit ASC
                ");
                $afficher -> execute();
                $res = $afficher->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $array) {
                    ?><tr><?php
                    foreach ($array as $v) {
                        ?><td><?php echo($v);?></td><?php
                    }
                    ?></tr><?php
                }
                ?>
            </tbody>
        </table>
        <a href="categorie.php"><h3>Ajouter des produits</h3></a>
    </div>
    </body>
</html> 