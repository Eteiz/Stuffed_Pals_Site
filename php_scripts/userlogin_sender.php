<?php
require_once 'db_connect.php';
header('Content-Type: application/json');
session_start();

$response = ['status' => 0, 'msg' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, user_password FROM user WHERE user_login = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['user_password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;

            $response['status'] = 1;
            $response['msg'] = "Login successful.";
        } else {
            $response['msg'] = "Incorrect username or password";
        }
    } else {
        $response['msg'] = "Incorrect username or password";
    }

    $stmt->close();
    $conn->close();
} else {
    $response['msg'] = "Invalid request method.";
}

echo json_encode($response);
?>