<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_destroy();

// Send confirmation response (optional)
echo json_encode([
  "success" => true,
  "message" => "Logged out successfully"
]);
?>
