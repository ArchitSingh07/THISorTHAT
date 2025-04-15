<?php
session_start();
include 'db_connect.php';

$token = $_POST['credential'] ?? null;

if (!$token) {
    die("No token received from Google.");
}

// Verify the token using Google's endpoint
$google_response = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($token));
$payload = json_decode($google_response, true);

if (!$payload || !isset($payload['email'])) {
    die("Invalid ID token.");
}

$email = $payload['email'];
$name = $payload['name'] ?? 'User';

// Check if user exists
$stmt = $conn->prepare("SELECT id, uniqueness_score FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // New user – insert with default score
    $defaultScore = 1000;
    $insert = $conn->prepare("INSERT INTO users (username, email, uniqueness_score) VALUES (?, ?, ?)");
    $insert->bind_param("ssi", $name, $email, $defaultScore);
    $insert->execute();
    $user_id = $insert->insert_id;
    $uniqueness = $defaultScore;
} else {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];
    $uniqueness = $row['uniqueness_score'];
}

// Set session variables
$_SESSION['user_id'] = $user_id;
$_SESSION['username'] = $name;

// Send back sessionStorage injection
echo "
<script>
  sessionStorage.setItem('uniquenessScore', $uniqueness);
  window.location.href = '/THISorTHAT/title_page.html';
</script>
";
exit;
?>
