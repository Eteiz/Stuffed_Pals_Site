<?php
session_start();
if (isset($_POST['logout-button'])) {
    unset($_SESSION['user_logged']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_login']);

    // Destroying session
    // session_destroy();
    
    header('Location: ../index.php');
    exit;
}
header('Location: ../index.php');
exit;
?>