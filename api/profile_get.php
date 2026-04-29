<?php
header('Content-Type: application/json');

if (!isset($_COOKIE['userID'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Not logged in']);
  exit;
}

$userId = $_COOKIE['userID'];

$servername = "localhost";
$username = "hackberr_trevor";
$password = "J0B9?p*^?hss+Sos";
$dbname = "hackberr_trevor";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// Get user info
$query = "SELECT id, email, favTeam FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $query) or die("Could not select user.");
$user = [];
if ($row = mysqli_fetch_array($result)) {
  $user = $row;
}

// Get total players
$totalPlayers = 0;
$query = "SELECT COUNT(*) AS total FROM players";
$result = mysqli_query($conn, $query) or die("Could not count players.");
if ($row = mysqli_fetch_array($result)) {
  $totalPlayers = (int)$row['total'];
}

// Get collection
$collection = [];
$query = "SELECT playerID FROM collections WHERE userID = '$userId'";
$result = mysqli_query($conn, $query) or die("Could not select collection.");
while ($row = mysqli_fetch_array($result)) {
  $collection[] = $row['playerID'];
}

$collectedCount = count($collection);

echo json_encode([
  'user' => $user,
  'collection' => $collection,
  'collectionStats' => [
    'total' => $totalPlayers,
    'collected' => $collectedCount
  ]
]);
?>
