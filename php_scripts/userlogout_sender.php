<?php
session_start();
if (isset($_POST['logout-button'])) {
    unset($_SESSION['user_logged']);
    unset($_SESSION['user_id']);

    // Możesz również całkowicie zniszczyć sesję, jeśli wolisz
    // session_destroy();
    header('Location: ../index.php');
    exit;
}
header('Location: ../index.php');
exit;
?>