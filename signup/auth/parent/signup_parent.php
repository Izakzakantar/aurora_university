<?php
require_once "Parent.php"; // Use Parent class

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $parent = new ParentUser();

    $prenom = htmlspecialchars(strip_tags(trim($_POST['prenom'])));
    $nom = htmlspecialchars(strip_tags(trim($_POST['nom'])));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['mot_de_passe']; // You can add password validation
    $telephone = htmlspecialchars(strip_tags(trim($_POST['telephone'])));
    $relation = htmlspecialchars(strip_tags(trim($_POST['relation'])));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("❌ Invalid email format.");
    }

    // Register parent
    if ($parent->registerParent($prenom, $nom, $email, $password, $telephone, $relation)) {
        echo "✅ Parent registration successful! <h1><a href='../login.html'>Login Here</a></h1>";
    } else {
        echo "❌ Error: Email might already exist or registration failed.";
    }
}
?>
