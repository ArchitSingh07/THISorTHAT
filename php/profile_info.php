<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode([
    "success" => false,
    "message" => "Not logged in"
  ]);
  exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email, uniqueness_score FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
if ($user = $result->fetch_assoc()) {
  echo json_encode([
    "success" => true,
    "user" => $user
  ]);
} else {
  echo json_encode([
    "success" => false,
    "message" => "User not found"
  ]);
}
?>
