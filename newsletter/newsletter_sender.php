<?php
require_once "../db_connect.php";

$response = ["status" => 0, "msg" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["msg"] = "Please provide a valid email address.";
    } elseif (!isset($_POST["consent"])) {
        $response["msg"] = "You must agree to the terms.";
    } else {
        $stmt = $conn->prepare("CALL AddToNewsletter(?, @p_status, @p_message)");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
        $result = $select->fetch_assoc();
        $response["status"] = $result["status"];
        $response["msg"] = $result["message"];

        $stmt->close();
    }
    $conn->close();
} else {
    $response["msg"] = "Invalid request method.";
}

header("Content-Type: application/json");
echo json_encode($response);
exit();
?>