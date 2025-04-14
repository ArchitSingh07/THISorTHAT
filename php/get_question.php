<?php
include 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
  // Fetch question by ID (for review page)
  $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
  $stmt->bind_param("i", $id);
} else {
  // Random question by smoothed priority
  $stmt = $conn->prepare("SELECT * FROM questions ORDER BY RAND() * ((priority / 10) + 1) DESC LIMIT 1");
}

$stmt->execute();
$result = $stmt->get_result();

if ($question = $result->fetch_assoc()) {
  echo json_encode($question);
} else {
  echo json_encode(["error" => "No question found"]);
}
?>
