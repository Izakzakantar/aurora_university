<?php
require_once "User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    $user = new User();

    // Check if email and password exist in $_POST before using them
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";

    if (empty($email) || empty($password)) {
        die("❌ Error: Email and password are required.");
    }

    if ($user->login($email, $password)) {
        // ✅ Fix the incorrect concatenation (use . instead of +)
        echo "Welcome, " . $_SESSION['user_name']; 

        /* Uncomment this when ready to redirect
        if ($_SESSION['role'] === "Enseignant") {
            header("Location: ../../teacher_dashboard.php");
        } else {
            header("Location: ../../dashboard.php");
        }
        */
        exit();
    } else {
        echo "❌ Invalid email or password.";
    }
}
?>
