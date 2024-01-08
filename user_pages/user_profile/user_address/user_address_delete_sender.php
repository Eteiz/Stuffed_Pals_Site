<?php
require_once "../../../init.php";
header("Content-Type: application/json");

$userId = $_SESSION['user_id'];
$addressId = $_POST["user_address_id"] ?? null;
$addressId = filter_var($addressId, FILTER_SANITIZE_NUMBER_INT);
$addressId = filter_var($addressId, FILTER_VALIDATE_INT);

$response = deleteUserAddress($userId, $addressId);

echo json_encode($response);
?>
