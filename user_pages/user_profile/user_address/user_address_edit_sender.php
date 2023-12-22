<?php
require_once "../../../init.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $userAddressId = $_POST['address_id'] ?? null;
    $userFirstName = $_POST['user_firstname'] ?? '';
    $userLastName = $_POST['user_lastname'] ?? '';
    $userEmail = $_POST['user_email'] ?? '';
    $userPhoneNumber = $_POST['user_phone'] ?? '';
    $userHomeAddress = $_POST['user_homeaddress'] ?? '';
    $userCity = $_POST['user_city'] ?? '';
    $userPostalCode = $_POST['user_postalcode'] ?? '';
    $userState = $_POST['user_state'] ?? '';
    $userCountry = $_POST['user_country'] ?? '';

    $response = updateUserAddress($userId, $userAddressId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry); 
}
echo json_encode($response);
?>