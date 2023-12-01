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
            <!-- <div class="section-image-display">
                <div class="main-image-displayer">
                    <div class="main-image-slider" style="width: 550px; transform: translateX(0px);">
                        <img src="assets\products\plush-accessories\plush_accessory_11\boots_1.png"
                            alt="Mini black boots on pink background ">
                    </div>
                </div>
                <div class="icon-image-displayer">
                    <div class="icon-image-slider" style="width: 110px;">
                        <img src="assets\products\plush-accessories\plush_accessory_11\boots_1.png"
                            alt="Mini black boots on pink background " class="icon-focused" style="opacity: 1;">
                    </div>
                </div>
            </div>
            <div class="section-content">
                <div class="section-content-description">
                    <h3>Supplier's name</h3>
                    <h1>Midnight Elegance Booties</h1>
                    <h4>
                        Step into a world of sophistication with our Midnight Elegance Booties, perfectly tailored
                        for your plushie's formal occasions. Crafted with velvety black fabric and detailed
                        stitching, these boots offer both style and comfort.
                    </h4>
                    <ul>
                        <li>The materials used for crafting are safe for the environment</li>
                        <li>Tailored to meet individual preferences</li>
                        <li>Designed with meticulous attention to detail and to ensure durability</li>
                    </ul>
                </div>
                <div class="section-content-action">
                    <div class="section-content-action-description">
                        <div class="review-section">
                            There will be review section
                        </div>
                        <h2>80.00 PLN</h2>
                    </div>
                    <div class="section-content-action-buttons">
                        <div class="quantity-button"><button id="decrease-quantity-button"
                                class="hyperlink_button_reverse" disabled="">-</button>
                            <input type="number" id="product-quantity" class="transparent_background" value="0" min="0"
                                max="0" readonly="">
                            <button id="increase-quantity-button" class="hyperlink_button_reverse"
                                disabled="">+</button>
                        </div>
                        <button class="hyperlink_button" type="sumbit" disabled="">OUT OF STOCK</button>
                    </div>
                </div> -->
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