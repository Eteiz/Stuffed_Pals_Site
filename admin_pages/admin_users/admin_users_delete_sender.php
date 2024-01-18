<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
$userId = intval($_POST["user_id"]);

if ($userId > 0) {
    $stmt = $conn->prepare("CALL DeleteUser(?)");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $response = ["status" => 0, "msg" => "Account deleted successfully."];
    } else {
        $response = ["status" => 1, "msg" => "Error while deleting account."];
    }
} else {
    $response = ["status" => 1, "msg" => "Incorrect parameters."];
}  
$stmt->close();    
echo json_encode($response);
?>