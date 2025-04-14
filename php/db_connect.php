<?php
$host = "localhost";
$user = "root";
$pass = ""; // Default in XAMPP
$db = "thisorthat";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
