<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <title> Sign in | Stuffed Pals</title>
    <meta name="description" content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords" content="plushies, stuffed animals, stuffed">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="img\logo_icon.png" type="img\logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-control" content="no-cache">

	<link rel="stylesheet" href="styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include 'site_static_parts\navbar.php'; ?>
    <header>
        <div class="header-content white_background">
            <h1> Sign in </h1>
            <h3> 
                Embark on your personalized journey by entering your username and password!
            </h3>
        </div>
    </header>
    <main>
        <section class="form-section white_background">
            <form method="post" action="/php_scripts/userlogin_sender.php" id="user-login-form">
                <h2> Login </h2>
                <label for="username" class="form-field"> 
                    <h3> Username </h3>
                    <input type="text" name="username" required placeholder="Username" maxlength="40">
                </label>
                <label for="password" class="form-field">
                    <h3> Password </h3>
                    <input type="password" name="password" required placeholder="Password" maxlength="40">
                </label>
                <div class="form-extra-information">
                    <a class="hyperlink_text" href="user_retrieve_password.php"> Forgot your password? </a>
                    </br>
                    <a class="hyperlink_text" href="user_register.php"> Not registered? Create an account</a>
                </div>
                <button class="hyperlink_button" type="submit" name="send-message-button">SIGN IN</button>
                <div class="form-result">
                    <h4 id="user-login-form-status" class="form-status"></h4>
                </div>
            </form>
        </section>
	</main>
	<?php include 'site_static_parts\footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js_scripts/userlogin_updater.js"></script>
</body>
</html>