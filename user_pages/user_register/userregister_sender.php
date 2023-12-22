<?php
require_once "../../db_connect.php";
header("Content-Type: application/json");

$response = ["status" => 1, "msg" => "Unknown action."];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);

    // Username validation
    // Length
    if (strlen($username) < 5 || strlen($username) > 40) {
        $response = ["status" => 1, "msg" => "Username must be 5-40 characters long."];
    }
    // Special characters
    else if (!preg_match("/^[A-Za-z0-9]+$/", $username)) {
        $response = ["status" => 1, "msg" => "Username must contain only letters and numbers."];
    }
    // Password validation
    // Length
    else if (strlen($password) < 8 || strlen($password) > 40) {
        $response = ["status" => 1, "msg" => "Password must be 8-40 characters long."];
    }
    // Special characters
    else if (!preg_match("/^[ -~]+$/", $password)) {
        $response = ["status" => 1, "msg" => "Password must contain only keyboard characters."];
    }
    else {
        // Password hasning
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