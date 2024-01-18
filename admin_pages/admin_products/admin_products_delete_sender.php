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

$productId = intval($_POST["product_id"] ?? 0);
if ($productId > 0) {
    $stmt = $conn->prepare("CALL DeleteProduct(?, @p_status, @p_message)");
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
        $result = $select->fetch_assoc();
        $response = ["status" => $result['status'], "msg" => $result['message']];
    } else {
        $response = ["status" => 1, "msg" => "Error while deleting product."];
    }
    $stmt->close();
} else {
    $response = ["status" => 1, "msg" => "Incorrect parameters."];
}      
echo json_encode($response);
?>
