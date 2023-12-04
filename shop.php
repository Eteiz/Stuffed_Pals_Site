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

    <title>Shop | Stuffed Pals</title>
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

    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="shop-all-page">
    <?php include 'site_static_parts\navbar.php'; ?>
    <header class="image-background">
        <div class="header-content white_background default-box-shadow">
            <h1> Our Shop </h1>
            <h3>
                Everything you need is here! From plush bases to accessories, you'll find the perfect solution for a stuffed companion.
            </h3>
        </div>
    </header>
    <main class="white background">
        <aside id="filters-section" class="white_background">
            <h3> Filter by:</h3>
            <!-- FILTERS SECTION -->
            <form id="filters-form" class="section-content">
                <!-- Sorting options -->
                <div id="filters-sort-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Sorting:</h4>
                    </div>
                    <div class="section-content-row-description open">
                        <label> <input type="radio" name="product_sort" value="price_asc"> Price: low to high </label>
                        <label> <input type="radio" name="product_sort" value="price_desc"> Price: high to low </label>
                        <label> <input type="radio" name="product_sort" value="date_newest"> Date: new to old </label>
                        <label> <input type="radio" name="product_sort" value="date_oldest"> Date: old to new </label>
                        <label> <input type="radio" name="product_sort" value="alpha_asc"> Alphabetically: a-z </label>
                        <label> <input type="radio" name="product_sort" value="alpha_desc"> Alphabetically: z-a </label>
                    </div>
                </div>
                <!-- Price filter -->
                <div id="filters-price-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Price:</h4>
                    </div>
                    <div class="section-content-row-description open">
                        <div class="price-range">
                            <input type="number" id="price-min" name="price-min" placeholder="min PLN" min="0" oninput="validity.valid||(value='');">
                            —
                            <input type="number" id="price-max" name="price-max" placeholder="max PLN" min="0" oninput="validity.valid||(value='');">
                        </div>
                    </div>
                </div>
                <!-- Category filter -->
                <div id="filters-category-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Category:</h4>
                    </div>
                    <div class="section-content-row-description open">
                        <?php include 'php_scripts/categoryfilter_loader.php'; ?>
                    </div>
                </div>
                <!-- Clear and apply changes button -->
                <button class="hyperlink_button" name="filters-clear-button" type="submit"> CLEAR FILTERS </button>
                <button class="hyperlink_button" name="filters-apply-button" type="submit"> APPLY FILTERS </button>
            </form>
        </aside>
        <!-- PRODUCT LIST -->
        <article id="products-display-section" class="white_background">
            <!-- <div id="loading-animation" class="dots-5" style="display: none;"></div> -->
            <!-- productdisplay_loader.php -->
        </article>
    </main>
    <?php include 'site_static_parts/newsletter_form.php'; ?>
    <?php include 'site_static_parts/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js_scripts/newsletter_updater.js"></script>
    <script src="js_scripts/productfilter_accordion.js"></script>
    <script src="js_scripts/productlist_updater.js"></script>
</body>
</html>