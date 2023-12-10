<?php
require_once "../init.php";
if (is_user_logged_in()) {
    header("Location: ../../user_pages/user_profile/user_profile.php");
    exit;
}
?>