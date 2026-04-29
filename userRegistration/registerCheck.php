<?php

// Extract the form data with POST
$newEmail = $_POST['newEmail'];
$newPass = $_POST['newPass']; 
$favTeam = $_POST['favTeam']; 
$player = isset($_POST['player']) ? $_POST['player'] : '';
$type   = isset($_POST['type']) ? $_POST['type'] : '';
$baseQS = http_build_query([
    'player' => $player,
    'type'   => $type
]);

// Connect to the database
$servername = "localhost";
$username = "hackberr_trevor";
$password = "J0B9?p*^?hss+Sos";
$dbname = "hackberr_trevor";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {die("Connection failed: " . mysqli_connect_error());}

// Check to see if the user's e-mail already exists
$isUser = 0;

$query = "SELECT * FROM users WHERE email = '$newEmail' ";
$result = mysqli_query($conn, $query) or die ("Could not select.");
while ($row = mysqli_fetch_array($result)){
    extract($row);
    $isUser = 1;
}	

// If it does, redirect them back to account page with query string
if($isUser == 1) {
    header("Location: register.html?" . $baseQS . "&error=1");
    exit();
}

// If not, insert into database and redirect them to the login page with player/type
else {
    $query = "INSERT INTO users (email, password, favTeam) VALUES ('$newEmail', '$newPass', '$favTeam')";
    $result = mysqli_query($conn, $query) or die ("Could not insert.");
    header("Location: ../login/login.html?" . $baseQS);
    exit();
}
?>