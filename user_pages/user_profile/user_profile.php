<?php
require_once "../../init.php";
if (!is_user_logged_in()) {
    header("Location: ../../user_pages/user_login/user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Your profile | Stuffed Pals</title>
    <meta name="description" content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords" content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="../../assets/logo_icon.png" type="../../assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-control" content="no-cache">

	<link rel="stylesheet" href="../../styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include "../../site_static_parts/navbar.php"; ?>
    <header class="image-background">
        <div class="header-content white_background default-box-shadow">
            <h1>Hello <?php echo htmlspecialchars($_SESSION["user_login"], ENT_QUOTES, "UTF-8"); ?></h1>
            <h3> 
                Welcome to your personalized dashboard, where your preferences shape your experience.
            </h3>
        </div>
    </header>
    <main>
        <div class="form-section white_background">
            <form action="../../user_pages/user_profile/userlogout_sender.php" method="post" id="user-logout-form">
                <button class="hyperlink_button" type="submit" name="logout-button">LOG OUT</button>
            </form>  
            <form action="../../user_pages/user_profile/userdelete_sender.php" method="post" id="user-delete-form">
                <label>
                    <input type="checkbox" name="confirm-delete" required>
                    I am aware that deleting my account is an irreversable action.
                </label>
                <button class="hyperlink_button" type="submit" name="delete-button">DELETE ACCOUNT</button>
                <div class="form-result">
                    <h4 id="user-delete-form-status" class="form-status"></h4>
                </div>
            </form>
        </div>
	</main>
	<?php include "../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="userdelete_updater.js"></script>
</body>
</html>