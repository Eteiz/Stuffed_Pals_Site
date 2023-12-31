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
    <?php include "../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> Your Cart </h1>
            <h3> Everything you need is here! From plush bases to accessories, you"ll find the perfect solution for a
                stuffed companion. 
            </h3>
        </div>
    </header>
    <main id="checkout" class="white-background">
        <!---
        <form id="checkout-form" class="white-background default-box-shadow">
        </form>
        <article id="checkout-list">
                <div class="section-title">
                <h1> Shopping cart </h1>
                <div class="section-title-description">
                    <h3 style="width: 300px;">Product</h3>
                    <h3 style="width: 75px;">Price</h3>
                    <h3 style="width: 125px;">Quantity</h3>
                    <h3 style="width: 125px;">Subtotal</h3>
                    <h3 style="width: 50px;"></h3>
                </div>
            </div>
            <hr style="height: 2px;">
            <div class="section-content">
                <form class="section-row">
                    <div class="section-row-image">
                        <img src="../assets/products/plush-accessories/plush_accessory_6/boots_1.png"></img>
                        <div class="section-row-image-description">
                            <h3> Product 1 </h3>
                            <div class='form-result' data-product-id='16'>
                                <h4 class='form-result-status'></h4>
                            </div>
                        </div>
                    </div>
                    <h3 class="product-price"> 100$ </h3>
                    <div class='quantity-button'>
                        <button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='16'>-</button>
                        <input type='number' class='product-quantity transparent_background' data-product-id='16' value='1' min='1' max='5'>
                        <button type='button' class='increase-quantity-button hyperlink_button_reverse' data-product-id='16'>+</button>
                    </div>
                    <h3 class="product-subtotal"> $100 </h3> 
                    <button class="delete-button hyperlink_button_reverse" data-product-id='16'>X</button>
                </form>
                <hr>
                <form class="section-row">
                    <div class="section-row-image">
                        <img src="../assets/products/plush-accessories/plush_accessory_6/boots_1.png"></img>
                        <div class="section-row-image-description">
                            <h3> Product 1 </h3>
                            <div class='form-result' data-product-id='16'>
                                <h4 class='form-result-status'></h4>
                            </div>
                        </div>
                    </div>
                    <h3 class="product-price"> 100$ </h3>
                    <div class='quantity-button'>
                        <button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='16'>-</button>
                        <input type='number' class='product-quantity transparent_background' data-product-id='16' value='1' min='1' max='5'>
                        <button type='button' class='increase-quantity-button hyperlink_button_reverse' data-product-id='16'>+</button>
                    </div>
                    <h3 class="product-subtotal"> $100 </h3> 
                    <button class="delete-button hyperlink_button_reverse" data-product-id='16'>X</button>
                </form>
            </div> 
        </article>
        -->
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="cart_updater.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("newsletter-form", "subscribe-button", "../newsletter/newsletter_sender.php", "newsletter");
        });
    </script>   
</body>

</html>