<?php
require_once "../init.php";
if(!is_user_logged_in()) {
    header("Location: ../../user_pages/user_login/user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Cart | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>
<body id="cart-page">
    <div id="overlay">
        <div id="overlay-content" class="white-background default-box-shadow">
            <h1>Your cart is still on reservation!</h1>
            <h3>If you modify the content of your cart <span class="highlighted">the reservation will automatically cancel</span>.<br>Are you sure you want to continue shopping?</h3>
            <button id="overlay-close" class="hyperlink_button" title="Continue browsing"> Continue browsing </button>
            <div id="overlay-buttons">
                <button id="overlay-cancel" class="hyperlink_button_reverse" title="Cancel reservation">Cancel reservation</button>
                <a href="../checkout_page/checkout_page.php" class="hyperlink_button_reverse" title="/checkout_page/checkout_page.php"> Go to checkout </a>
            </div>
        </div>
    </div> 
    <?php include "../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> Your Cart </h1>
            <h3> 
                Ready to bring your new friend to life? Your cart is filled with everything you've picked out for your perfect stuffed companion. 
            </h3>
        </div>
    </header>
    <main id="checkout" class="white-background section-rows">
        <!-- Content of cart -->
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="cart_updater.js"></script>
    <script src="../js_scripts/overlay_alert_updater.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("newsletter-form", "subscribe-button", "../newsletter/newsletter_sender.php", "newsletter");
        });
    </script>   
</body>
</html>