<?php
require_once 'db_connect.php'; 
header('Content-Type: application/json');

$response = ['status' => 0, 'msg' => '']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM user WHERE user_login = ? OR user_email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['msg'] = "Username or email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (user_login, user_password, user_email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        if ($stmt->execute()) {
            $response['status'] = 1; 
            $response['msg'] = "Registration successful.";
        } else {
            $response['msg'] = "Error during registration.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    $response['msg'] = "Invalid request method.";
}
echo json_encode($response);
exit;
?>
