<?php
require_once "Teacher.php"; // Use Teacher class instead of User

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Initialize the Teacher object
    $teacher = new Teacher();

    // Secure and sanitize input data
    $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
    $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['mot_de_passe'];
    $specialisation = htmlspecialchars(strip_tags(trim($_POST['specialisation'])));
    $telephone = htmlspecialchars(strip_tags(trim($_POST['telephone'])));
    $date_embauche = htmlspecialchars(strip_tags(trim($_POST['date_embauche'])));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email format.");
    }

    // Register teacher
    if ($teacher->registerTeacher($prenom, $nom, $email, $password, $specialisation, $telephone, $date_embauche)) {
        echo "✅ Registration successful! <h1><a href='../login.html'>Login Here</a></h1>";
    } else {
        echo "❌ Error: Email might already exist or failed registration.";
    }
}
?>
