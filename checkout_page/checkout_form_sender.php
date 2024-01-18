<?php
require_once "../init.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];

    // Checking form parameters
    if(checkCartReservation($userId)) {
        $userFirstName = substr(filter_var($conn->real_escape_string($_POST['user_firstname']), FILTER_SANITIZE_STRING), 0, 100);
        $userLastName = substr(filter_var($conn->real_escape_string($_POST['user_lastname']), FILTER_SANITIZE_STRING), 0, 100);
        $userEmail = substr(filter_var($conn->real_escape_string($_POST['user_email']), FILTER_SANITIZE_EMAIL), 0, 255);
        $userPhoneNumber = substr(filter_var($conn->real_escape_string($_POST['user_phone']), FILTER_SANITIZE_STRING), 0, 12);
        $userHomeAddress = substr(filter_var($conn->real_escape_string($_POST['user_homeaddress']), FILTER_SANITIZE_STRING), 0, 100);
        $userCity = substr(filter_var($conn->real_escape_string($_POST['user_city']), FILTER_SANITIZE_STRING), 0, 100);
        $userPostalCode = substr(filter_var($conn->real_escape_string($_POST['user_postalcode']), FILTER_SANITIZE_STRING), 0, 6);
        $userState = substr(filter_var($conn->real_escape_string($_POST['user_state']), FILTER_SANITIZE_STRING), 0, 100);
        $userCountry = substr(filter_var($conn->real_escape_string($_POST['user_country']), FILTER_SANITIZE_STRING), 0, 100);
        $userDeliveryMethod = substr(filter_var($conn->real_escape_string($_POST['delivery_method']), FILTER_SANITIZE_STRING), 0, 100);
        $userPaymentMethod = substr(filter_var($conn->real_escape_string($_POST['payment_method']), FILTER_SANITIZE_STRING), 0, 100);

        if(isset($_POST["remember_address"])) {
            // Adding address to user addresses
            $response = addUserAddress($userId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry); 
            if($response["status"] == 0) {
                // Creating order
                $response = finalizeOrder($userId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry, $userDeliveryMethod, $userPaymentMethod); 
            } 
        }
        else {
            // Creating order
            $response = finalizeOrder($userId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry, $userDeliveryMethod, $userPaymentMethod); 
        }
    }
    else {
        header("Location: ../checkout_page/order_received.php");
        exit; 
    }
}
if($response["status"] == 0) {
    cancelCartReservation($userId);
}
echo json_encode($response);
?>