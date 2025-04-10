<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "aurora_db";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Create a MySQLi procedural connection
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);

        // Check connection
        if (!$this->conn) {
            die("❌ Connection failed: " . mysqli_connect_error());
        }

        
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
