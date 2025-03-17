<?php
require_once "User.php";

class Student extends User {
    public function __construct() {
        parent::__construct();
        $this->role = "Élève";
    }

    // Function to fetch parent_id using the parent's last name (nom)
    private function getParentIdByLastName($parent_nom) {
        $stmt = mysqli_prepare($this->conn, "SELECT id FROM arents WHERE nom = ?");
        mysqli_stmt_bind_param($stmt, "s", $parent_nom);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $parent_id);
        mysqli_stmt_fetch($stmt);

        return $parent_id ?? null; // Return the parent_id if found, otherwise NULL
    }

    // Function to register a student
    public function registerStudent($prenom, $nom, $email, $password, $date_naissance, $genre, $adresse, $telephone, $parent_nom) {
        // Fetch parent_id dynamically
        $parent_id = $this->getParentIdByLastName($parent_nom);

        // Register student in Utilisateurs table
        $user_id = parent::register($prenom, $nom, $email, $password, $this->role);
        if ($user_id) {
            // Insert student details into Eleves table
            $stmt = mysqli_prepare($this->conn, "INSERT INTO Eleves (id, date_naissance, genre, adresse, telephone, parent_id) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "issssi", $user_id, $date_naissance, $genre, $adresse, $telephone, $parent_id);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
