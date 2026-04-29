<?php
# connect to database
$servername = "localhost";
$username = "hackberr_trevor";
$password = "J0B9?p*^?hss+Sos";
$dbname = "hackberr_trevor";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

# check required GET parameters
if (!isset($_GET['player'])) {
    http_response_code(400);
    echo json_encode(["error" => "No player provided"]);
    exit;
}
if (!isset($_GET['type'])) {
    http_response_code(400);
    echo json_encode(["error" => "No player type provided"]);
    exit;
}

$playerID = $_GET['player'];
$type = $_GET['type'];

# select query based on type
switch($type) {
    case 'batting':
        $sql = "SELECT playerID, yearID, teamID, lgID, AB, R, H, `2B`, `3B`, HR, RBI, SB, CS, BB, SO 
                FROM batting WHERE playerID = '$playerID'";
        break;
    case 'pitching':
        $sql = "SELECT playerID, yearID, teamID, lgID, W, L, G, GS, CG, SHO, SV, H, ER, HR, BB, SO, BAOpp, ERA, IPouts
                FROM pitchers WHERE playerID = '$playerID'";
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Invalid type"]);
        exit;
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
    exit;
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
exit;
?>