<?php
require_once "../db_connect.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sanitizedEmail = substr(filter_var($conn->real_escape_string($_POST["email"]), FILTER_SANITIZE_EMAIL), 0, 255);

    if (!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)) {
        $response = ["status" => 1, "msg" => "Please provide a valid email address."];
    } elseif (!isset($_POST["consent"])) {
        $response = ["status" => 1, "msg" => "You must agree to the terms."];
    } else {
        $stmt = $conn->prepare("CALL AddToNewsletter(?, @p_status, @p_message)");
        $stmt->bind_param("s", $sanitizedEmail);
        $stmt->execute();

        $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
        $result = $select->fetch_assoc();
        $response = ["status" => $result["status"], "msg" => $result["message"]];
        $stmt->close();
    }
    $conn->close();
} 
echo json_encode($response);
?>