<?php
require_once "../config.php";
session_start();
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = substr(filter_var($conn->real_escape_string($_POST["user_name"]), FILTER_SANITIZE_STRING), 0, 64);
    $username_hashed = hash("sha256", $username);
    $password = $_POST["user_password"];

    $stmt = $conn->prepare("SELECT admin_password FROM admin_table WHERE admin_login = ?");
    $stmt->bind_param("s", $username_hashed);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user["admin_password"])) {
            $_SESSION["admin_logged"] = true;

            $response = ["status" => 0, "msg" => "Login successful."];
        } else {
            $response = ["status" => 1, "msg" => "Incorrect username or password."];
        }
    } else {
        $response = ["status" => 1, "msg" => "Incorrect username or password."];
    }
    $stmt->close();
    $conn->close();
} else {
    $response = ["status" => 1, "msg" => "Unknown action."];
}
echo json_encode($response);
?>