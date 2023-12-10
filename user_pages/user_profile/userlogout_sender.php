<?php
require_once "../../init.php";
if (isset($_POST["logout-button"])) {
    log_user_out();
}
header("Location: ../../index.php");
exit;
?>