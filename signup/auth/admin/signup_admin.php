<?php
require_once "classes/Admin.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mot_de_passe = $_POST['mot_de_passe']; // don't trim passwords

    $admin = new Admin();
    $result = $admin->registerAdmin($prenom, $nom, $email, $mot_de_passe);

    if ($result) {
        // Redirect to admin dashboard
        header("Location: /dashboars/admin/dashboard.php");

        exit();
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>
