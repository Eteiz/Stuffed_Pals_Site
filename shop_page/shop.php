<?php require_once "../init.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Shop | Stuffed Pals</title>
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

<body id="shop-page">
    <div id="overlay">
        <div id="overlay-content" class="white-background default-box-shadow">
            <h1>Your cart is still on reservation!</h1>
            <h3>If you modify the content of your cart <span class="highlighted">the reservation will automatically cancel</span>.<br>Are you sure you want to continue shopping?</h3>
            <button id="overlay-close" class="hyperlink_button" title="Continue browsing"> Continue browsing </button>
            <div id="overlay-buttons">
                <button id="overlay-cancel" class="hyperlink_button_reverse" title="Cancel reservation">Cancel reservation</button>
                <button onclick="window.location.href='../checkout_page/checkout_page.php'" class="hyperlink_button_reverse" title="/checkout_page/checkout_page.php"> Go to checkout </button>
            </div>
        </div>
    </div> 
    <?php include "../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
        <h1> Our Shop </h1>
            <h3>
                Everything you need is right here! From plush bases to an array of accessories, you'll discover the perfect elements to create your ideal stuffed companion. 
            </h3>
        </div>
    </header>
    <main class="white-background section-rows">
        <form id="filters-section" class="default-box-shadow">
            <h2> Filter by:</h2>
            <hr class="outer">
            <div id="responsive-filters">
                <div id="sort-filters" class="section-columns">
                    <h4>Products Sorting:</h4>
                    <label> <input type="radio" name="product_sort" value="price_asc"> Price: low to high </label>
                    <label> <input type="radio" name="product_sort" value="price_desc"> Price: high to low </label>
                    <label> <input type="radio" name="product_sort" value="date_newest"> Date: new to old </label>
                    <label> <input type="radio" name="product_sort" value="date_oldest"> Date: old to new </label>
                    <label> <input type="radio" name="product_sort" value="alpha_asc"> Alphabetically: A-Z </label>
                    <label> <input type="radio" name="product_sort" value="alpha_desc"> Alphabetically: Z-A </label>
                </div>
                <div id="category-filters" class="section-columns">
                    <h4>Products Category:</h4>
                    <div class="section-columns">
                        <?php include "categoryfilter_loader.php"; ?>
                    </div>
                </div>
                <div id="supplier-filters" class="section-columns">
                    <h4> Product Supplier: </h4>
                    <div class="section-columns">
                        <?php include "supplierfilter_loader.php"; ?>
                    </div>
                </div>
                <div id="availability-filters" class="section-columns">
                    <h4> Products Availability: </h4>
                    <div class="section-columns">
                        <?php include "availabilityfilter_loader.php"; ?>
                    </div>
                </div>
            </div>
            <div id="price-filters" class="section-columns">
                <h4>Products Price:</h4>
                <div class="section-columns">
                    <div class="price-range">
                        <input type="number" id="price-min" name="price-min" placeholder="Min PLN" min="0"
                            oninput="validity.valid||(value='');">
                        —
                        <input type="number" id="price-max" name="price-max" placeholder="Max PLN" min="0"
                            oninput="validity.valid||(value='');">
                    </div>
                </div>
            </div>
            <button class="hyperlink_button_reverse" name="filters-clear-button" type="submit" title="Clear filters">Clear Filters</button>
            <button class="hyperlink_button" name="filters-apply-button" type="submit" title="Apply filters">Apply Filters</button>
        </form>
        <div id="product-display-section" class="white-background">
            <!-- <div class="default-box-shadow section-element">
                <a href='../product_page/product_page.php?product='> <img src="../assets/placeholder.png" alt="Product Image"> </a>
                <div class="section-columns">
                    <h3 class="product-name">Product Name</h3>
                    <h4>★★★★☆ (3.98)</h4>
                    <form>
                        <h2 class="product-price">Product Price</h2>
                        <button class="hyperlink_button">Add to Cart</button>
                        <div class='form-result'>Test</div>
                    </form>
                </div>
            </div> -->
        </div>
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="productlist_updater.js"></script>
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