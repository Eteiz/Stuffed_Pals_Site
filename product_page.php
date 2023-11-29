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

    <title>Shop All | Stuffed Pals</title>
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

    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="product-page">
    <?php include 'site_static_parts\navbar.php'; ?>
    <main>
        <div id="product-section" class="white_background">
            <?php include 'php_scripts/product_loader.php'; ?>
        </div>
    </main>
    <?php include 'site_static_parts/newsletter_form.php'; ?>
    <?php include 'site_static_parts/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js_scripts/quantitybutton_updater.js"></script>
    <script src="js_scripts/newsletter_updater.js"></script>
    <script src="js_scripts/product_slider.js"></script>

</body>
</html>