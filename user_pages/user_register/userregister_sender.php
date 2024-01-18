<?php
require_once "../../config.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = substr(filter_var($conn->real_escape_string($_POST["user_name"]), FILTER_SANITIZE_STRING), 0, 40);
    $email = substr(filter_var($conn->real_escape_string($_POST["user_email"]), FILTER_SANITIZE_EMAIL), 0, 100);
    $password = substr(filter_var($conn->real_escape_string($_POST["user_password"]), FILTER_SANITIZE_STRING), 0, 60);

    if (strlen($username) < 5) {
        $response = ["status" => 1, "msg" => "Username must contain 5-40 characters."];
    } else if (!preg_match("/^[A-Za-z0-9]+$/", $username)) {
        $response = ["status" => 1, "msg" => "Username must contain only letters and numbers."];
    }
    else if (strlen($password) < 7) {
        $response = ["status" => 1, "msg" => "Password must contain 7-60 characters."];
    } else if (!preg_match("/^[ -~]+$/", $password)) {
        $response = ["status" => 1, "msg" => "Password must contain only keyboard characters."];
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("CALL RegisterUser(?, ?, ?, @p_status, @p_message)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);
        $stmt->execute();

        $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
        $result = $select->fetch_assoc();
        $response = ["status" => $result["status"], "msg" => $result["message"]];

        $stmt->close();
        $conn->close();
    }
} else {
    $response = ["status" => 1, "msg" => "Unknown action."];
}
echo json_encode($response);
?>