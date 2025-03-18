<?php

if (file_exists("DBConnexionCredential.php")) {
    require_once "DBConnexionCredential.php";

    $dbCredential = new DBConnexionCredential();
    $username = $dbCredential->getUserName();
    $password = $dbCredential->getPassword();
} else {
    $username = "user"; // Change this to your MySQL username
    $password = "password"; // Change this to your MySQL password
}

/**
 * Class DBConnexion is used to create a connection to a local MySQL database.
 * It uses the PDO library to establish the connection.
 * @var string SERVER_NAME Name of the server (localhost).
 * @var string USERNAME Database username.
 * @var string PASSWORD Database password.
 * @var PDO $conn Holds the database connection object.
 */
class DBConnexion
{
    const SERVER_NAME = "localhost";
    private $username;
    private $password;
    private $conn;
    private $error;

    /**
     * DBConnexion constructor establishes a connection to the database.
     * The constructor initializes the connection using PDO and sets error handling to exceptions.
     */
    public function __construct()
    {
        try {
            // Assign dynamic credentials to properties
            $this->username = $GLOBALS['username'];
            $this->password = $GLOBALS['password'];

            // Create a new PDO connection with the dynamic parameters
            $this->conn = new PDO("mysql:host=" . self::SERVER_NAME . ";dbname=TP2LPBDB", $this->username, $this->password);
            // Set the connection to use utf8mb4 character set
            // $this->conn->exec("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_general_ci'");

            // Set error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pdoe) {
            // Display the error message if an exception was caught
            $this->error = "Error while connecting to the database: {$pdoe->getMessage()}<br>\n";
            // Set the connection to null if the connection fails.
            $this->conn = null;
        }
    }

    /**
     * DBConnexion destructor closes the connection when the object is destroyed.
     */
    public function __destruct()
    {
        // Close the connection when the object is destroyed
        $this->conn = null;
    }

    /**
     * Returns the database connection.
     * @return PDO|null Returns the PDO connection object or null if the connection failed.
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Returns the error message if the connection failed.
     * @return string|null Returns the error message or null if the connection was successful.
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Fetches all the rows from a table in the database.
     * @param string $tableName Name of the table to fetch the rows from.
     * @return array|null Returns an array of rows or null if the connection is null.
     */
    public function findAll($tableName)
    {
        try {
            // Check if the connection is null
            if ($this->conn === null) {
                return null;
            }

            // Prepare the SQL query
            $stmt = $this->conn->prepare("SELECT * FROM $tableName");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error with fetchAll : " . $e->getMessage();
            return null;
        }
    }

    /**
     * Executes a query on the database.
     * @param string $query SQL query to execute.
     * @return array|null Returns an array of rows or null if the connection is null.
     */
    public function queryExecute($query)
    {
        try {
            // Check if the connection is null
            if ($this->conn === null) {
                return null;
            }

            // Prepare the SQL query
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error with fetchAll : " . $e->getMessage();
            return null;
        }
    }
}
