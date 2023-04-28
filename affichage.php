<!DOCTYPE html>
<html>

<head>
    <title>Affichage</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="boite">
        <h2>Résultats de veille</h2>
        <table>
            <thead>
                <th>Date</th>
                <th>Nom de la source</th>
                <th>Auteur</th>
                <th>Language</th>
                <th>Évaluation</th>
                <th>Résumer de l'information</th>
            </thead>
            <tbody>
                <?php
                include "connexion-pdo.php";
                $afficher = $dbco->prepare(
                    "SELECT r.date, s.nomSource, r.auteur, l.nomLanguage, r.evaluation, r.resume
                    FROM resultats AS r
                    INNER JOIN sources AS s
                    ON r.idSource = s.id
                    INNER JOIN languages AS l
                    ON r.idLanguage = l.id
                    ORDER BY r.date ASC
                "
                );
                $afficher->execute();
                $res = $afficher->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $array) {
                    ?>
                    <tr>
                        <?php
                        foreach ($array as $v) {
                            ?>
                            <td>
                                <?php echo ($v); ?>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div class="ajoutResultat">
            <h2>Ajouter un résultat</h2>
            <form method="post" action="affichage.php">
                <div class="champ">
                    <label>Date : </label>
                    <input class="field" type="text" name="date" placeholder="jj/mm/aaaa" pattern="[0-9/]{10}" required />
                </div>
                <div class="champ">
                    <label>Source : </label>
                    <select name="source">
                        <?php
                        include "connexion-pdo.php";
                        try {
                            $selectSource = $dbco->prepare("SELECT nomSource FROM sources
                            ");
                            $selectSource->execute();
                            $resultatSource = $selectSource->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($resultatSource as $array) {
                                foreach ($array as $v) {
                                    ?>
                                    <option value="<?php echo ($v) ?>"><?php echo ($v) ?></option>
                                    <?php
                                }
                            }

                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();

                        }
                        ?>
                    </select>
                </div>
                <div class="champ">
                    <label>Auteur : </label>
                    <input class="field" type="text" name="auteur" pattern="[A-Za-z àèé^-]{2,30}" required />
                </div>
                <div class="champ">
                    <label>Language : </label>
                    <select name="language">
                        <?php
                        include "connexion-pdo.php";
                        try {
                            $selectLanguage = $dbco->prepare("SELECT nomLanguage FROM languages
                            ");
                            $selectLanguage->execute();
                            $resultatLanguage = $selectLanguage->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($resultatLanguage as $array) {
                                foreach ($array as $v) {
                                    ?>
                                    <option value="<?php echo ($v) ?>"><?php echo ($v) ?></option>
                                    <?php
                                }
                            }

                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();

                        }
                        ?>
                    </select>
                </div>

                <div class="champ">
                    <label>Note sur 10 : </label>
                    <select name="evaluation" id="evaluation">
                        <option value="0">1</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>

                    </select>
                </div>
                <div class="champ">
                    <label>Résumé et apprentissages : </label>
                    <input class="field resume" type="text" name="resume" placeholder="Veuillez écrire un résumer de vos apprentissages" pattern="[A-Za-z àèé^-]{2,300}" required />
                </div>
                <div class="champ center">
                    <input class="btn" type="submit" name="ajouterResultat" value="Ajouter" />
                </div>
            </form>
            <?php
            include "connexion-pdo.php";
            if (isset($_POST["ajouterResultat"])) {
                $date = $_POST["date"];
                $source = $_POST["source"];
                $auteur = $_POST["auteur"];
                $language = $_POST["language"];
                $evaluation = $_POST["evaluation"];
                $resume = $_POST["resume"];

                $findSource = $dbco->prepare("SELECT id
            FROM sources
            WHERE nomSource = '$source'
            ");
                $findSource->execute();
                $resSource = $findSource->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resSource as $array) {
                    foreach ($array as $v) {
                        $idSource = $v;
                    }
                }
                $findLanguage = $dbco->prepare("SELECT id
            FROM languages
            WHERE nomLanguage = '$language'
            ");
                $findLanguage->execute();
                $resLanguage = $findLanguage->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resLanguage as $array) {
                    foreach ($array as $v) {
                        $idLanguage = $v;
                    }
                }
                try {
                    $insert = "INSERT INTO resultats(date, idSource, auteur, idLanguage, evaluation, resume)
                VALUES
                ('$date',$idSource,'$auteur',$idLanguage,$evaluation,'$resume')
                ";
                    $dbco->exec($insert);
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }

            }
            ?>
        </div>
        <div class="ajoutSource">
            <h2>Ajouter une source</h2>
            <form method="post" action="affichage.php">
                <div class="champ">
                    <label>Source : </label>
                    <input class="field" type="text" name="source" pattern="[A-Za-z /.-]{2,30}" required />
                </div>
                <div class="champ center">
                    <input class="btn" type="submit" name="ajouterSource" value="Ajouter" />
                </div>
            </form>
            <?php
            include "connexion-pdo.php";
            if (isset($_POST["ajouterSource"])) {
                $source = "'" . $_POST["source"] . "'";

                try {
                    $insert = "INSERT INTO sources(nomSource)
                VALUES
                ($source)
                ";
                    $dbco->exec($insert);
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
            ?>
        </div>
        <div class="ajoutLanguage">
            <h2>Ajouter un language</h2>
            <form method="post" action="affichage.php">
                <div class="champ">
                    <label>Language : </label>
                    <input class="field" type="text" name="Language" pattern="[A-Za-z +#-]{2,30}" required />
                </div>
                <div class="champ center">
                    <input class="btn" type="submit" name="ajouterLanguage" value="Ajouter" />
                </div>
            </form>
        </div>
            <?php
            include "connexion-pdo.php";
            if (isset($_POST["ajouterLanguage"])) {
                $Language = "'" . $_POST["Language"] . "'";

                try {
                    $insert = "INSERT INTO languages(nomLanguage)
                    VALUES
                    ($Language)
                    ";
                    $dbco->exec($insert);
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
            ?>
    </div>
</body>

</html>