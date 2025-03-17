<?php

// Insertion of the DBConnexion class
require_once 'DBConnexion.php';

// Connexion to the database
$db = new DBConnexion();


$resultPersonne = $db->findAll('Personnes');
$resultMariages = $db->findAll('Mariages');
?>

<!DOCTYPE html>
<html lang="en">

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
        <nav class="navbar border border-2 border-black"></nav>
    </header>

    <main>
        <div id=" table-db-container" class="d-flex justify-content-center w-100 gap-5 mt-10">
            <table id="personnes" class="table table-striped table-hover w-25">
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
                        echo "<tr>";
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

            <table id="mariages" class="table table-striped table-hover w-50">
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
                    for ($i = 0; $i < count($resultMariages); $i++) {
                        $row = $resultMariages[$i];
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['id_personne1'] . "</td>";
                        echo "<td>" . $row['id_personne2'] . "</td>";
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
</body>

</html>
