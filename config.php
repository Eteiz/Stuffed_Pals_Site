<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $cookieLifetime = 60 * 60 * 24 * 7; 
// $secure = true; 
// $httpOnly = true; 
// session_set_cookie_params($cookieLifetime, '/', '', $secure, $httpOnly);
?>
