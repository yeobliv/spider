<?php

/**
 * Class MySQL
 * This class handles the connection to a MySQL database using PDO.
 */
class MySQL
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $pdo;

    /**
     * Constructor to initialize database connection parameters.
     *
     * @param string $host Database host
     * @param string $dbname Database name
     * @param string $username Database username
     * @param string $password Database password
     * @param string $charset Character set, defaults to utf8mb4
     */
    public function __construct($host, $dbname, $username, $password, $charset = 'utf8mb4')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->connect();
    }

    /**
     * Establishes a PDO connection to the database.
     */
    private function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    /**
     * Executes a SQL query and returns the result.
     *
     * @param string $sql The SQL query to execute
     * @return array An array of the result set
     */
    public function query($sql)
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error executing query: " . $e->getMessage();
        }
    }

    /**
     * Closes the PDO connection when the object is destroyed.
     */
    public function __destruct()
    {
        $this->pdo = null;
    }
}