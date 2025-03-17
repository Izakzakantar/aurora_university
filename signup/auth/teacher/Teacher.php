<?php
require_once "User.php";

class Teacher extends User {
    public function __construct() {
        parent::__construct();
        $this->role = "Enseignant";
    }

    public function registerTeacher($prenom, $nom, $email, $password, $specialisation, $telephone, $date_embauche) {
        $user_id = parent::register($prenom, $nom, $email, $password, $this->role);
        if ($user_id) {
            $stmt = mysqli_prepare($this->conn, "INSERT INTO Enseignants (id, specialisation, telephone, date_embauche) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "isss", $user_id, $specialisation, $telephone, $date_embauche);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }
}
?>
