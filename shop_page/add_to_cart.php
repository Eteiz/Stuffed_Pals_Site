<?php
require_once "../init.php";
header("Content-Type: application/json");

$response = ["status" => 0, "msg" => ""];

// Checking if the user is logged in
if (!is_user_logged_in()) {
    $response["status"] = 2;
    $response["msg"] = "";
    echo json_encode($response);
    exit;
}
$productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;
// Checking if product parameters are correct
if ($productId == null) {
    $response["status"] = 0;
    $response["msg"] = "Invalid product data.";
    echo json_encode($response);
    exit;
}
$response = addProductToCart($_SESSION['user_id'], $productId, 1);
echo json_encode($response);
?>