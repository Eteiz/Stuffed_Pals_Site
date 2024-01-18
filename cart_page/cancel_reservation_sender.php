<?php
require_once "../init.php";

$userId = $_SESSION['user_id'];
cancelCartReservation($userId);
?>