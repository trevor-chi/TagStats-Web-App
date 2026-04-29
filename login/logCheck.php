<?php

// Extract the form data with POST
$tryEmail = $_POST['tryEmail'];
$tryPass = $_POST['tryPass'];

// **Use only hidden fields from the form for player/type**
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
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }

// Check to see if the user's e-mail is in the database (original email check)
$isUser = 0;

$query = "SELECT * FROM users WHERE email = '$tryEmail' ";
$result = mysqli_query($conn, $query) or die ("Could not select.");
while ($row = mysqli_fetch_array($result)){
    extract($row);
    $isUser = 1;
}	

// If not, redirect back to login page with error
if($isUser == 0) {
    header("Location: login.html?" . $baseQS . "&error=1");
    exit();
}

// If email exists, check password
if($tryPass == $password) {
    // Set cookie for 30 days
    setcookie("userID", $id, time() + (86400 * 30), "/pink/tchilders/tagStats/"); 

    // Redirect to playerPage.html with player/type from hidden fields
    if($player) {
        $redirectUrl = "../mainPages/playerPage.html?" . $baseQS;
        header("Location: " . $redirectUrl);
    } else {
        header("Location: ../mainPages/home.html?" . $baseQS);
    }
    exit();
} else {
    // Password mismatch
    header("Location: login.html?" . $baseQS . "&error=1");
    exit();
}
?>