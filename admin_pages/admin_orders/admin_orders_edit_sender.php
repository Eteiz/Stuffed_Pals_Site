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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = filter_var($_POST['order_id'], FILTER_SANITIZE_NUMBER_INT);
    $orderId = (int)$orderId;
    $orderId = min(max($orderId, PHP_INT_MIN), PHP_INT_MAX);

    $orderStatus = substr(filter_var($conn->real_escape_string($_POST['order_status']), FILTER_SANITIZE_STRING), 0, 100);

    $stmt = $conn->prepare("UPDATE order_details SET order_status = ? WHERE id = ?");
    $stmt->bind_param("si", $orderStatus, $orderId);
    if ($stmt->execute()) {
        $response = ["status" => 0, "msg" => "Order status updated successfully."];
    } else {
        $response = ["status" => 1, "msg" => "Error while editing product."];
    }
}
$stmt->close();
echo json_encode($response);
?>