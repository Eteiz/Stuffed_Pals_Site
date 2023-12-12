<?php
require_once "../../init.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, user_password FROM user WHERE user_login = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user["user_password"])) {
            $_SESSION["user_logged"] = true;
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_login"] = $username;

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