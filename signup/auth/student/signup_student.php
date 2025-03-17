<?php
require_once "Student.php"; // Use Student class

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student = new Student();

    // Secure and sanitize input data
    $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
    $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['mot_de_passe']; // Add password validation if needed
    $date_naissance = htmlspecialchars(strip_tags(trim($_POST['date_naissance'])));
    $genre = htmlspecialchars(strip_tags(trim($_POST['genre'])));
    $adresse = htmlspecialchars(strip_tags(trim($_POST['adresse'])));
    $telephone = htmlspecialchars(strip_tags(trim($_POST['telephone'])));
    $parent_nom = htmlspecialchars(strip_tags(trim($_POST['parent_nom']))); // Parent's last name to find parent_id

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email format.");
    }

    // Register student
    if ($student->registerStudent($prenom, $nom, $email, $password, $date_naissance, $genre, $adresse, $telephone, $parent_nom)) {
        echo "✅ Student registration successful! <h1><a href='../login.html'>Login Here</a></h1>";
    } else {
        echo "❌ Error: Registration failed. Parent may not exist.";
    }
}
?>
