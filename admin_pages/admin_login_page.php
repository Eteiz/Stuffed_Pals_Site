<?php 
session_start();
if (isset($_SESSION["admin_logged"]) && $_SESSION["admin_logged"] == true) {
    header("Location: ../admin_pages/admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Admin login | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="admin-account-page">
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> Admin login </h1>
        </div>
    </header>
    <main class="white-background">
        <section class="form-section white-background">
            <form id="admin-login-form" action="../admin_pages/adminlogin_sender.php" method="post">
                <h2> Login </h2>
                <label for="username-field" class="form-field">
                    <h3> Username </h3>
                    <input type="text" id="username-field" name="user_name" required placeholder="Username"
                        maxlength="64" autocomplete="username">
                </label>
                <label for="password-field" class="form-field">
                    <h3> Password </h3>
                    <input type="password" id="password-field" name="user_password" required placeholder="Password"
                        maxlength="60" autocomplete="current-password">
                    <img id="toggle-password" src="../../assets/icons/hide_icon.png" alt="Eye view icon" title="Toggle password visibility"
                        onclick="togglePasswordVisibility()"></img>
                </label>
                <button class="hyperlink_button" type="submit" name="login-button" title="Sign in">
                    <div class="button-text">Sign in</div>
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result"></div>
            </form>
        </section>
    </main>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/passwordvisibility_changer.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
            handleFormSubmit("admin-login-form", "login-button", "../admin_pages/adminlogin_sender.php", "admin-login");
        });
    </script>   
</body>

</html>
