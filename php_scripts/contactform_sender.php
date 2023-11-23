<?php
header("Content-Type: application/json; charset=utf-8");

$firstname = isset($_POST['first-name']) ? $_POST['first-name'] : "";
$lastname = isset($_POST['last-name']) ? $_POST['last-name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$message = isset($_POST['message']) ? $_POST['message'] : "";
$response = array();

if (empty($firstname)) {
    $response['status'] = 0;
    $response['msg'] = "Please provide a valid first name.";
} else if (empty($lastname)) {
    $response['status'] = 0;
    $response['msg'] = "Please provide a valid last name.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['status'] = 0;
    $response['msg'] = "Please provide a valid email address.";
} else if (empty($message)) {
    $response['status'] = 0;
    $response['msg'] = "Please provide a not empty message.";
} else {
    $headers = "MIME-Version: 1.0\r\nContent-type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit";
    $message_body = "Stuffed Pals Contact Form:\n";
    $message_body .= "Name and last name: $firstname $lastname\n";
    $message_body .= "Email address: $email\n\n";
    $message_body .= $message;
    
    if (mail("AartaMambroziak@outlook.com", "Stuffed Pals Contact Form", $message_body, $headers)) {
        $response['status'] = 1;
        $response['msg'] = "Mail successfully sent";
    } else {
        $response['status'] = 0;
        $response['msg'] = "There was a problem sending the email.";
    }
}

echo json_encode($response);
exit;
?>