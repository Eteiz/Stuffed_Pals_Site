<?php require_once "./init.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Home | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="./assets/logo_icon.png" type="./assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>
<body id="index-page">
    <?php include "./site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> Find a new best friend </h1>
            <div class="text_slider">
                <div class="text_slider_element">
                    <h1>you want</h1>
                    <h1>you need</h1>
                    <h1>you love</h1>
                </div>
            </div>
            <h3> Creating a new best friend has never been easier and faster than now. What are you waiting for? </h3>
            <button class="hyperlink_button" onclick="window.location.href='./shop_page/shop.php'" title="/shop_page/shop_page.php">Start now</button> 
        </div>
    </header>
    <main class="white-background">
        <div id="introduction-section" class="section-rows">
            <div>
                <h2> Having a fluffy and cuddly friend is fun </h2>
                <h4> There's something truly special about having a plush companion by your side. 
                    Each cuddly friend we create at Stuffed Pals is more than just a toy; it's a source of comfort, a spark for imagination, and a constant companion in all of life's adventures. 
                    Our plushies are designed to bring a touch of warmth and joy to your everyday life, becoming cherished friends that stay by your side through thick and thin. 
                </h4>
                <button class="hyperlink_button" onclick="window.location.href='./shop_page/shop.php'" title="/shop_page/shop_page.php">Browse collection</button>
            </div>
            <img src="./assets/StuffedPals_AboutUs_3.png" alt="Stuffed Pals Logo" title="Stuffed Pals Logo"></img>
        </div>
        <div id="collection-section" class="default-gradient-background">
            <h1> Browse our collection </h1>
            <h3> From essentials to what makes your pal unique! </h3>
            <div class="section-rows">
                <a id="bases-category" class="hyperlink_icon" href="./shop_page/shop.php?category=Bases" title="/shop_page/shop_page.php?category=Bases">
                    <h2> Plush bases </h2>
                </a>
                <a id="clothes-category" class="hyperlink_icon" href="./shop_page/shop.php?category=Clothes" title="/shop_page/shop_page.php?category=Clothes">
                    <h2> Plush clothes </h2>
                </a>
                <a id="accessories-category" class="hyperlink_icon" href="./shop_page/shop.php?category=Accessories" title="/shop_page/shop_page.php?category=Accessories">
                    <h2> Plush accessories </h2>
                </a>
            </div>
        </div>
    </main>
    <?php include "./newsletter/newsletter_form.php"; ?>
    <?php include "./site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("newsletter-form", "subscribe-button", "../newsletter/newsletter_sender.php", "newsletter");
        });
    </script>  
</body>
</html>