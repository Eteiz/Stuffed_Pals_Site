<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please provide a valid email address.";
    } else if (!isset($_POST['consent'])) {
        echo "You must agree to the terms.";
    } else {
        $checkEmailQuery = "SELECT * FROM newsletter WHERE email_address = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            header('Location: /newsletter_result.php');
            exit();
        } else {
            $sql = "INSERT INTO newsletter (email_address) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                header('Location: /newsletter_result.php');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
        $conn->close();
    }
}
?>
