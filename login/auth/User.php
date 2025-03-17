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

    
    public function register($prenom, $nom, $email, $password, $role,$specialisation,$telephone,$date_embauche) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // prepare statement to prevent SQL injection
        $stmt = mysqli_prepare($this->conn, "INSERT INTO Utilisateurs (prenom, nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $prenom, $nom, $email, $hashed_password, $role);

       
        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($this->conn);
            mysqli_stmt_close($stmt);
            $stmt = mysqli_prepare($this->conn, "INSERT INTO enseignants (id, specialisation, telephone, date_embauche) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "isss", $user_id, $specialisation, $telephone, $date_embauche);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $user_id;


        } else {
            return false;
        }
    }
    public function login($email,$password){
        $stmt=mysqli_prepare($this->conn,"SELECT id, prenom, nom, mot_de_passe, role FROM utilisateurs WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id, $prenom, $nom, $hashed_password, $role);
        mysqli_stmt_fetch($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0 && password_verify($password, $hashed_password)) {
            // Start session and store user details
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $prenom . " " . $nom;
            $_SESSION['role'] = $role;
            
            mysqli_stmt_close($stmt);
            return $prenom;
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
    }

   
   
}
?>
