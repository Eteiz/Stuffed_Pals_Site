<?php
require_once "../init.php";
header("Content-Type: application/json");
// Checking if user is logged in
if (!is_user_logged_in()) {
    echo json_encode(["status" => 2, "msg" => "User not logged in."]);
    exit;
}

$productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : null;
$quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : null;

$response = ["status" => 1, "msg" => "Unknown action"];
$response = addProductToCart($_SESSION["user_id"], $productId, $quantity);
echo json_encode($response);
?>