<?php
require_once "User.php";

class ParentUser extends User {
    public function __construct() {
        parent::__construct();
        $this->role = "Parent";
    }

    public function registerParent($prenom, $nom, $email, $password, $telephone, $relation) {
        $user_id = parent::register($prenom, $nom, $email, $password, $this->role);
        if ($user_id) {
            $stmt = mysqli_prepare($this->conn, "INSERT INTO parents (id, prenom, nom, telephone, email, relation) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "isssss", $user_id, $prenom, $nom, $telephone, $email, $relation);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
