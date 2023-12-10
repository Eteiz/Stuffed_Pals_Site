<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_logged']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_login'])) {
    $_SESSION['user_logged'] = false;
	$_SESSION['user_id'] = NULL;
    $_SESSION['user_login'] = NULL;
}

function is_user_logged_in() {
    return isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true;
}

function log_user_out() {
        unset($_SESSION['user_logged']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_login']);
        session_destroy();
        header('Location: ../../index.php');
        exit;
}

function manage_guest_cart() {
    if (!is_user_logged_in()) {
        echo '<script>var isGuest = true;</script>';
    }
}
?>