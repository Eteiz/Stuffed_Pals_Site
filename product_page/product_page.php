<?php
require_once "../init.php";
if (isset($_GET["product"])) {
    $productId = intval($_GET["product"]); 
    $stmt = $conn->prepare("SELECT id FROM Product WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if ($result->num_rows == 0) {
        header("Location: ../page_error.php");
        exit;
    }
} else {
    header("Location: ../page_error.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title> Product page | Stuffed Pals</title>
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
<body id="product-page">
    <div id="overlay">
        <div id="overlay-content" class="white-background default-box-shadow">
            <h1>Your cart is still on reservation!</h1>
            <h3>If you modify the content of your cart <span class="highlighted">the reservation will automatically cancel</span>.<br>Are you sure you want to continue shopping?</h3>
            <button id="overlay-close" class="hyperlink_button" title="Continue browsing"> Continue browsing </button>
            <div id="overlay-buttons">
                <button id="overlay-cancel" class="hyperlink_button_reverse" title="Cancel reservation">Cancel reservation</button>
                <button class="hyperlink_button_reverse" onclick="window.location.href='../checkout_page/checkout_page.php'" title="/checkout_page/checkout_page.php"> Go to checkout </button>
            </div>
        </div>
    </div> 
    <?php include "../site_static_parts/navbar.php"; ?>
    <main>
        <div class="section-rows white-background">
            <!-- <div class="section-images section-columns">
                <div class="image-displayer">
                    <div class="image-displayer-slider section-rows">
                        <img src="../assets/products/plush-accessories/plush_accessory_11/boots_1.png"
                            alt="Mini black boots on pink background ">
                        <img src="../assets/products/plush-accessories/plush_accessory_11/boots_2.png"
                        alt="Mini black boots on pink background ">
                    </div>
                </div>
                <div class="image-carousel section-rows">
                    <img src="../assets/products/plush-accessories/plush_accessory_11/boots_1.png"
                         alt="Mini black boots on pink background " class="icon-focused" style="opacity: 1;">
                    <img src="../assets/products/plush-accessories/plush_accessory_11/boots_1.png"> </img>
                </div>
            </div>
            <div class="section-content">
                <div>
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
                <div class="section-action">
                    <h3> ★★★★☆ (3.98) </h3>
                    <h2>80.00 PLN</h2>
                    <form class="section-rows">
                        <div class="quantity-button section-rows">
                            <button id="decrease-quantity-button" class="hyperlink_button_reverse" >-</button>
                            <input type="number" id="product-quantity" class="transparent_background" value="0" min="0"
                                max="10" >
                            <button id="increase-quantity-button" class="hyperlink_button_reverse">+</button>
                        </div>
                        <button id="add-button" class="hyperlink_button" type="sumbit" disabled="">OUT OF STOCK</button>
                    </form>
                    <div class='form-result'></div>
                </div> -->
                <?php include "product_loader.php"; ?>
            </div>
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="quantitybutton_updater.js"></script>
    <script src="product_slider.js"></script>
    <script src="../cart_page/add_to_cart_updater.js"></script>
    <script src="../js_scripts/overlay_alert_updater.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("newsletter-form", "subscribe-button", "../newsletter/newsletter_sender.php", "newsletter");
        });
    </script>    
</body>
</html>
