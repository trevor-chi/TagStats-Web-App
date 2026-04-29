<?php
header('Content-Type: application/json');

if (!isset($_COOKIE['userID'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Not logged in']);
  exit;
}

$userId = $_COOKIE['userID'];
$playerId = $_POST['player_id'] ?? '';

if ($playerId === '') {
  http_response_code(400);
  echo json_encode(['error' => 'Missing player_id']);
  exit;
}

$servername = "localhost";
$username = "hackberr_trevor";
$password = "J0B9?p*^?hss+Sos";
$dbname = "hackberr_trevor";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// Validate player exists
$query = "SELECT playerid FROM players WHERE playerid = '$playerId'";
$result = mysqli_query($conn, $query) or die("Could not select player.");
if (!mysqli_fetch_array($result)) {
  http_response_code(404);
  echo json_encode(['error' => 'Player not found']);
  exit;
}

$query = "SELECT 1 FROM collections WHERE userID = '$userId' AND playerID = '$playerId'";
$result = mysqli_query($conn, $query) or die("Could not check collection.");
if (!mysqli_fetch_array($result)) {
  $query = "INSERT INTO collections (userID, playerID)
            VALUES ('$userId', '$playerId')";
  mysqli_query($conn, $query) or die("Could not insert collection.");
}

echo json_encode(['ok' => true]);
?>
