<?php
require_once "User.php";

class Admin extends User {
    public function __construct() {
        parent::__construct();
        $this->role = "Admin";
    }

    public function registerAdmin($prenom, $nom, $email, $password) {
        return parent::register($prenom, $nom, $email, $password, $this->role);
    }
}
?>
