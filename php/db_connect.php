<?php
$servername = "sql113.infinityfree.com";
$username = "if0_38757519";
$password = "XQS4ujprDyB";
$dbname = "if0_38757519_thisorthat";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
