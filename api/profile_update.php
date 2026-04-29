<?php
header('Content-Type: application/json');

if (!isset($_COOKIE['userID'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Not logged in']);
  exit;
}

$userId = $_COOKIE['userID'];
$favTeam = trim($_POST['favTeam'] ?? '');

if ($favTeam === '') {
  http_response_code(400);
  echo json_encode(['error' => 'favTeam is required']);
  exit;
}

$servername = "localhost";
$username = "hackberr_trevor";
$password = "J0B9?p*^?hss+Sos";
$dbname = "hackberr_trevor";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

$query = "UPDATE users SET favTeam = '$favTeam' WHERE id = '$userId'";
$result = mysqli_query($conn, $query) or die("Could not update.");

echo json_encode(['success' => true]);
?>