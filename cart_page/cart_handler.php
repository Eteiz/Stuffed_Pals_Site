<?php
require_once "../init.php";
header("Content-Type: application/json");
// Checking if user is logged in
if (!is_user_logged_in()) {
    echo json_encode(["status" => 2, "msg" => "User not logged in."]);
    exit;
}

$userId = $_SESSION["user_id"];
$action = $_POST["action"] ?? "";
$productId = intval($_POST["product_id"] ?? 0);
$quantity = intval($_POST["quantity"] ?? 0);

$response = ["status" => 1, "msg" => "Unknown action."];
switch ($action) {
    case "add":
        $updateResult = addProductToCart($userId, $productId, $quantity);
        $response = $updateResult;
        break;
    case "subtract":
        $updateResult = subtractProductFromCart($userId, $productId, $quantity);
        $response = $updateResult;
        break;
    case "update":
        $updateResult = updateProductFromCart($userId, $productId, $quantity);
        $response = $updateResult;
        break;
    case "remove":
        $removeResult = removeProductFromCart($userId, $productId);
        $response = $removeResult;
        break;
    default:
        break;      
}
echo json_encode($response);
?>
