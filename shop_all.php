<?php
session_start();
if (!isset($_SESSION['user_logged']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_login'])) {
    $_SESSION['user_logged'] = false;

	$_SESSION['user_id'] = NULL;
    $_SESSION['user_login'] = NULL;
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">

    <title> Shop all | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="shop-all-page">
    <?php include 'site_static_parts\navbar.php'; ?>
    <header>
        <div class="header-content white_background">
            <h1> Our Shop </h1>
            <h3>
                Everything you need is here! From plush bases to accessories, you'll find the perfect solution for a
                stuffed companion.
            </h3>
        </div>
    </header>
    <main>
        <aside id="filters-section" class="white_background">
            <h3> Filter by:</h3>
            <form id="filters-form" class="section-content">
                <!-- SORT -->
                <div id="product-sort-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Sorting:</h4>
                    </div>
                    <div class="section-content-row-description">
                        <label> <input type="radio" name="product_sort" value="price_asc"> Price: low to high </label>
                        <label> <input type="radio" name="product_sort" value="price_desc"> Price: high to low </label>
                        <label> <input type="radio" name="product_sort" value="date_newest"> Date: new to old </label>
                        <label> <input type="radio" name="product_sort" value="date_oldest"> Date: old to new </label>
                        <label> <input type="radio" name="product_sort" value="alpha_asc"> Alphabetically: a-z </label>
                        <label> <input type="radio" name="product_sort" value="alpha_desc"> Alphabetically: z-a </label>
                    </div>
                </div>
                <!-- PRICE -->
                <div id="product-price-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Price:</h4>
                    </div>
                    <div class="section-content-row-description">
                        <div class="price-range">
                            <input type="number" id="price-min" name="price-min" placeholder="min PLN" min="0"
                                oninput="validity.valid||(value='');">
                            —
                            <input type="number" id="price-max" name="price-max" placeholder="max PLN" min="0"
                                oninput="validity.valid||(value='');">
                        </div>
                    </div>
                </div>
                <!-- CATEGORY -->
                <div id="product-category-section" class="section-content-row">
                    <div class="section-content-row-header">
                        <h4>Products Category:</h4>
                    </div>
                    <div class="section-content-row-description">
                        <label><input type="checkbox" name="product_category[]" value="Bases"> Bases</label>
                        <label><input type="checkbox" name="product_category[]" value="Clothes"> Clothes</label>
                        <label><input type="checkbox" name="product_category[]" value="Accessories"> Accessories</label>
                    </div>
                </div>
                <button class="hyperlink_button" type="submit"> Apply filters </button>
            </form>
        </aside>
        <section id="product-section" class="white_background">
            <?php include 'php_scripts/product_loader.php'; ?> 
        </section>
    </main>
    <?php include 'site_static_parts\footer.php'; ?>
    <script src="js_scripts\product_filter_accordion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('filters-form').addEventListener('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                fetch('php_scripts/product_loader.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    var productSection = document.getElementById('product-section');
                    productSection.innerHTML = ''; // Usuń poprzednią zawartość
                    productSection.innerHTML = data; // Dodaj nową zawartość
                })
                .catch(error => console.error('Błąd:', error));
            });
        });
    </script>
</body>
</html>