<?php

// Insertion of the DBConnexion class
require_once 'DBConnexion.php';

// Connexion to the database
$db = new DBConnexion();


$resultPersonne = $db->findAll('Personnes');
$resultMariages = $db->findAll('Mariages');

// Get males
$query = "SELECT * FROM `Personnes` WHERE gender = 'M'";
$resultMales = $db->queryExecute($query);

// Get females
$query = "SELECT * FROM `Personnes` WHERE gender = 'F'";
$resultFemales = $db->queryExecute($query);

// Get divorces
$query = "SELECT `id` FROM `Mariages` WHERE divorce_date IS NOT NULL";
$resultDivorces = $db->queryExecute($query);

// Get mariage same sex
$query = "SELECT `id` FROM `Mariages` WHERE (SELECT `gender` FROM `Personnes` WHERE `id` = `id_personne1`) = (SELECT `gender` FROM `Personnes` WHERE `id` = `id_personne2`)";
$resultSameSex = $db->queryExecute($query);

// Get mariage and join name
$query = "SELECT `Mariages`.`id`, `Personnes`.`last_name` AS `last_name1`, `Personnes`.`first_name` AS `first_name1`, `Personnes2`.`last_name` AS `last_name2`, `Personnes2`.`first_name` AS `first_name2`, `Mariages`.`mariage_date`, `Mariages`.`divorce_date`, `Mariages`.`divorce_reason` FROM `Mariages` JOIN `Personnes` ON `Mariages`.`id_personne1` = `Personnes`.`id` JOIN `Personnes` AS `Personnes2` ON `Mariages`.`id_personne2` = `Personnes2`.`id`";
$resultMariagesWithNames = $db->queryExecute($query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS/JavaScript -->
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/script.js" defer></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>Devoir 2 - Pair-Programming</title>
</head>

<body>
    <header>
        <div class="border border-2 border-black d-flex justify-content-center align-items-center p-5">
            <h1>Pair Programming - Devoir pour le cours LPB</h1>
        </div>
    </header>

    <main>
        <div id="table-db-container" class="d-flex justify-content-center w-100 gap-5 mt-10">
            <table id="personnes" class="table table-striped table-hover w-25 m-2 border border-1 border-black">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the data from the database
                    for ($i = 0; $i < count($resultPersonne); $i++) {
                        $row = $resultPersonne[$i];

                        if (in_array($row, $resultFemales)) {
                            echo "<tr class='table-danger'>";
                        } elseif (in_array($row, $resultMales)) {
                            echo "<tr class='table-primary'>";
                        } else {
                            echo "<tr>";
                        }

                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['birth_date'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <table id="mariages" class="table table-striped table-hover w-50  m-2 border border-1 border-black">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Personne 1</th>
                        <th scope="col">Personne 2</th>
                        <th scope="col">Date de mariage</th>
                        <th scope="col">Date de divorce</th>
                        <th scope="col">Raison du divorce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the data from the database
                    for ($i = 0; $i < count($resultMariagesWithNames); $i++) {
                        $row = $resultMariagesWithNames[$i];

                        $divorced = false;
                        foreach ($resultDivorces as $divorce) {
                            if ($row['id'] == $divorce['id']) {
                                $divorced = true;
                                break;
                            }
                        }

                        $sameSex = false;
                        foreach ($resultSameSex as $same) {
                            if ($row['id'] == $same['id']) {
                                $sameSex = true;
                                break;
                            }
                        }
                        
                        if ($divorced) {
                            echo "<tr class='table-danger'>";
                        } elseif ($sameSex) {
                            echo "<tr class='table-warning'>";
                        } else {
                            echo "<tr>";
                        }

                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['first_name1'] . " " . $row['last_name1'] . "</td>";
                        echo "<td>" . $row['first_name2'] . " " . $row['last_name2'] . "</td>";
                        echo "<td>" . $row['mariage_date'] . "</td>";
                        echo "<td>" . $row['divorce_date'] . "</td>";
                        echo "<td>" . $row['divorce_reason'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <div class="d-flex flex-column border border-2 border-black w-100 align-items-center p-3">
            <h1>Auteurs :</h1>
            <div class="d-flex flex-row w-50 justify-content-between align-items-center">
                <h2 class="fs-4">Jonas Bette</h2>
                <h2 class="fs-4">Thibaud Quairiaux</h2>
            </div>
        </div>
    </footer>
</body>

</html>