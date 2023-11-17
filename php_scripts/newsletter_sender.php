<?php
require_once 'db_connect.php';

$response = ['status' => 0, 'msg' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['msg'] = "Please provide a valid email address.";
    } elseif (!isset($_POST['consent'])) {
        $response['msg'] = "You must agree to the terms.";
    } else {
        $checkEmailQuery = "SELECT * FROM newsletter WHERE email_address = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $response['msg'] = "This email is already subscribed.";
        } else {
            $sql = "INSERT INTO newsletter (email_address) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $response['status'] = 1;
                $response['msg'] = "Subscription successful!";
            } else {
                $response['msg'] = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }

    $conn->close();
} else {
    $response['msg'] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>