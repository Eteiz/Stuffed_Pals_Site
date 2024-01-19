<?php
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userFirstName = $_POST['first-name'] ?? '';
    $userLastName = $_POST['last-name'] ?? '';
    $userEmail = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($userFirstName)) {
        $response = ["status" => 1, "msg" => "Please provide a valid first name."];
    } elseif (empty($userLastName)) {
        $response = ["status" => 1, "msg" => "Please provide a valid last name."];
    } elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $response = ["status" => 1, "msg" => "Please provide a valid email address."];
    } elseif (empty($message)) {
        $response = ["status" => 1, "msg" => "Please provide a message."];
    } else {
        $headers = "MIME-Version: 1.0\r\nContent-type: text/plain; charset=utf-8\r\nContent-Transfer-Encoding: 8bit";
        $message_body = "Stuffed Pals Contact Form:\n";
        $message_body .= "Name and last name: " . $userFirstName . " " . $userLastName . "\n";
        $message_body .= "Email address: " . $userEmail . "\n\n";
        $message_body .= $message;

        if (mail("", "Stuffed Pals Contact Form", $message_body, $headers)) {
            $response = ["status" => 0, "msg" => "Mail successfully sent"];
        } else {
            $response = ["status" => 1, "msg" => "There was a problem sending the email."];
        }
    }
} else {
    $response = ["status" => 1, "msg" => "Unknown action."];
}
echo json_encode($response);
?>
