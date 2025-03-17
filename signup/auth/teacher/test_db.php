<?php
require_once "Database.php";

$db = new Database();
$conn = $db->getConnection();

echo "✅ Database connection successful!";
?>
