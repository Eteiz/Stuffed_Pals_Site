<?php
require_once "../../../init.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    log_user_out();
    $response = ["status" => 0, "msg" => "You successfully logged out."];
} else {
    $response = ["status" => 1, "msg" => "Unknown action."];
}
echo json_encode($response);
?>