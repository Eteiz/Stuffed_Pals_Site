<?php
session_start();
if (!isset($_SESSION['user_logged']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_login'])) {
    $_SESSION['user_logged'] = false;

	$_SESSION['user_id'] = NULL;
    $_SESSION['user_login'] = NULL;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Sign up | Stuffed Pals</title>
    <meta name="description" content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords" content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="../assets/logo_icon.png" type="../assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-control" content="no-cache">

	<link rel="stylesheet" href="../styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include '../site_static_parts/navbar.php'; ?>
    <header>
        <div class="header-content white_background">
            <h1> Sign up </h1>
            <h3> 
                Create account and embark on a journey of exclusive benefits and personalized experiences.
            </h3>
        </div>
    </header>
    <main>
        <section class="form-section white_background">
            <form method="post" action="../php_scripts/userregister_sender.php" id="user-register-form">
                <h2> Register </h2>
                <label for="username-field" class="form-field"> 
                    <h3> Username </h3>
                    <input type="text" id="username-field" name="username" required placeholder="Username" maxlength="40" autocomplete="username">
                </label>
                <label for="email-field" class="form-field">
                    <h3> Email address </h3>
                    <input type="email" id="email-field" name="email" required placeholder="Email address" maxlength="100" autocomplete="email">
                </label>
                <label for='password-field' class="form-field">
                    <h3> Password </h3>
                    <input type="password" id="password-field" name="password" required placeholder="Password" maxlength="40" autocomplete="new-password">
                    <img id="toggle-password" src='../assets/icons/hide_icon.png' alt="Eye view icon" onclick="togglePasswordVisibility()"></img>
                </label>
                <div class="form-extra-information">
                    <a class="hyperlink_text" href="../index.php"> Cancel </a>
                    </br>
                    <a class="hyperlink_text" href="../site_user_parts/user_login.php"> Already have an account? Log in</a>
                </div>
                <button class="hyperlink_button" type="submit" name="register-button">
                    SIGN UP
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result">
                    <h4 id="user-register-form-status" class="form-status"></h4>
                </div>
            </form>
        </section>
	</main>
	<?php include '../site_static_parts\footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../js_scripts/passwordvisibility_changer.js"></script>
    <script src="../js_scripts/userregister_updater.js"></script>
</body>
</html>