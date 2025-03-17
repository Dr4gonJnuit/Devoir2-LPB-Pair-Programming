<?php

// Insertion of the DBConnexion class
require_once '../DBConnexion.php';

// Connexion to the database
$db = new DBConnexion();

function displayCol($db, $tableName): void {
    // Test if the findAll method is working
    $table = $db->findAll($tableName);

    // Display the result
    for ($i = 0; $i < count($table); $i++) {
        // Display the result in the console if the script is executed in CLI mode
        echo (php_sapi_name() === 'cli') ? "\n" : "<br>";

        echo print_r($table[$i]);
    }
}

// Test if the connection is successful
if ($db->getConnection() != null) {
    echo "Connection successful";

    displayCol($db, 'Personnes');
    displayCol($db, 'Mariages');
} else {
    echo $db->getError();
}
