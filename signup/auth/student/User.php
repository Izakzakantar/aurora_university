<?php
require_once "Database.php";

class User {
    protected $db;
    protected $conn;
    protected $role;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function register($prenom, $nom, $email, $password, $role) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = mysqli_prepare($this->conn, "INSERT INTO Utilisateurs (prenom, nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $prenom, $nom, $email, $hashed_password, $role);

        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn); // Return new user ID
        } else {
            return false;
        }
    }
}
?>
