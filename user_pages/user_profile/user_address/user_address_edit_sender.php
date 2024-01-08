<?php
require_once "../../../init.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $userAddressId = $_POST['address_id'] ?? null;
    $userAddressId = filter_var($userAddressId, FILTER_SANITIZE_NUMBER_INT);
    $userAddressId = filter_var($userAddressId, FILTER_VALIDATE_INT);
    
    $userFirstName = substr(filter_var($conn->real_escape_string($_POST['user_firstname']), FILTER_SANITIZE_STRING), 0, 100);
    $userLastName = substr(filter_var($conn->real_escape_string($_POST['user_lastname']), FILTER_SANITIZE_STRING), 0, 100);
    $userEmail = substr(filter_var($conn->real_escape_string($_POST['user_email']), FILTER_SANITIZE_EMAIL), 0, 255);
    $userPhoneNumber = substr(filter_var($conn->real_escape_string($_POST['user_phone']), FILTER_SANITIZE_STRING), 0, 12);
    $userHomeAddress = substr(filter_var($conn->real_escape_string($_POST['user_homeaddress']), FILTER_SANITIZE_STRING), 0, 100);
    $userCity = substr(filter_var($conn->real_escape_string($_POST['user_city']), FILTER_SANITIZE_STRING), 0, 100);
    $userPostalCode = substr(filter_var($conn->real_escape_string($_POST['user_postalcode']), FILTER_SANITIZE_STRING), 0, 6);
    $userState = substr(filter_var($conn->real_escape_string($_POST['user_state']), FILTER_SANITIZE_STRING), 0, 100);
    $userCountry = substr(filter_var($conn->real_escape_string($_POST['user_country']), FILTER_SANITIZE_STRING), 0, 100);

    $response = updateUserAddress($userId, $userAddressId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry); 
}
echo json_encode($response);
?>