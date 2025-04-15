<?php
session_start();
include 'db_connect.php';

$input = $_POST['input'] ?? ''; // can be email or username
$password = $_POST['password'] ?? '';

if (!$input || !$password) {
  echo "Both fields required.";
  exit;
}

// Check if input is an email (contains @) or a username
if (strpos($input, '@') !== false) {
  $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
} else {
  $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
}

$stmt->bind_param("s", $input);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
  if (password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    echo "
            <script>
              sessionStorage.setItem('uniquenessScore', {$user['uniqueness_score']});
              window.location.href = '../title_page.html';
            </script>";
  exit;

  } else {
    echo "Wrong password.";
  }
} else {
  echo "User not found.";
}
?>
