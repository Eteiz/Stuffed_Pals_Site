<?php
require_once "../../../init.php";
header("Content-Type: application/json");

$userId = $_SESSION['user_id'];
$addressId = intval($_POST["user_address_id"] ?? 0);

$response = deleteUserAddress($userId, $addressId);

echo json_encode($response);
?>
