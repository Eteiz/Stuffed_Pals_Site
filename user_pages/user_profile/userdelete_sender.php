<?php
require_once "../../init.php";
header("Content-Type: application/json");

$response = ["status" => 0, "msg" => ""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["confirm-delete"])) {
        $response["msg"] = "You must confirm to delete your account.";
    } else {
        $userIdToDelete = $_SESSION["user_id"];

        $stmt = $conn->prepare("CALL DeleteUser(?)"); 
        $stmt->bind_param("i", $userIdToDelete);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response["status"] = 1;
            $response["msg"] = "Your account has been successfully deleted.";
            session_destroy();
        } else {
            $response["msg"] = "Error occurred during account deletion.";
        }
        $stmt->close();
    }
    $conn->close();
} else {
    $response["msg"] = "Invalid request method.";
}
echo json_encode($response);
?>