<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$id = $_POST['id'] ?? 0;
$choice = $_POST['choice'] ?? '';
$uniqueness = $_POST['uniqueness'] ?? null; 
$user_id = $_SESSION['user_id'] ?? null;

if (!$id || !in_array($choice, ['a', 'b'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$field = ($choice === 'a') ? 'votes_a' : 'votes_b';

// Update vote
$stmt = $conn->prepare("UPDATE questions SET $field = $field + 1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Fetch updated votes
$stmt = $conn->prepare("SELECT votes_a, votes_b FROM questions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if ($votes = $result->fetch_assoc()) {
    if ($user_id && $uniqueness !== null) {
        $stmt = $conn->prepare("UPDATE users SET uniqueness_score = ? WHERE id = ?");
        $stmt->bind_param("ii", $uniqueness, $user_id);

        $stmt->execute();
    }
    echo json_encode($votes);
} else {
    echo json_encode(["success" => false, "message" => "Vote fetch failed"]);
}
?>
