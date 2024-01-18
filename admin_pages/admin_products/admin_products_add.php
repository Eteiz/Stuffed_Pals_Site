<?php
session_start();
if (!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] !== true) {
    header("Location: ../../index.php");
    exit;
}

// Databse connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$categoryQuery = "SELECT * FROM Category";
$categoryResult = $conn->query($categoryQuery);

$supplierQuery = "SELECT * FROM Supplier";
$supplierResult = $conn->query($supplierQuery);
?>
<head>
    <meta charset="UTF-8">

    <title>Admin dashboard | Stuffed Pals</title>
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
<body id="admin-product-page">
    <main class="white-background">
            <div id="admin-product-section">
                <div class="section-header">
                    <h1>Add new product</h1>
                    <div class="section-information section-rows">
                        <h3 class="product-image">Image</h3>
                        <h3 class="product-name">Name<span class="alert">*</span></h3>
                        <h3 class="product-category">Category<span class="alert">*</span></h3>
                        <h3 class="product-supplier">Supplier<span class="alert">*</span></h3>
                        <h3 class="product-price">Price ($)<span class="alert">*</span></h3>
                        <h3 class="product-quantity">Qnt.<span class="alert">*</span></h3>
                    </div>
                </div>
                <hr class="outer">
                <div class="section-content">
                    <form id="admin-product-form" action="../../admin_pages/admin_products/admin_products_add_sender.php" class="section-element section-columns" method="post">
                        <div class="section-information section-rows">
                            <img id="image" class="product-image"></img>
                            <input type="text" id="product-name" class="product-name" name="product_name" maxlength="100" required 
                                placeholder="Product name" value=""></input>

                            <select class="product-category" name="product_category" required>
                                <?php while($row = $categoryResult->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['category_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <select class="product-supplier" name="product_supplier" required>
                                <?php while($row = $supplierResult->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['supplier_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>                 
                            <input type="number" class="product-price" name="product_price" min="0" step="0.01" required
                                placeholder="00.00" value=""></input>
                            <input type="number" class="product-quantity" name="product_quantity" min="0" step="0" required
                                placeholder="0" value=""></input>
                        </div>
                        <label for="product_image_path" class="product-image-path">
                            <h3>Product image path<span class="alert">*</span></h3>
                            <input type="text" class="product-image-path" name="product_image_path" maxlength="200" required 
                                placeholder="Image file path" value=""></input>
                            <h3>Product image description<span class="alert">*</span></h3>
                            <textarea name="product_image_description" required 
                                placeholder="Image description" value=""></textarea>
                        </label>
                        <label for="product-description" class="product-description">
                            <h3>Product description<span class="alert">*</span></h3>
                            <textarea name="product_description" required 
                                placeholder="Product description" value=""></textarea>
                        </label>
                        <div class="form-extra-information">
                            <a class="hyperlink_text" href="../../../admin_pages/admin_dashboard.php?content=products" title="/admin_pages/admin_dashboard.php?content=products">&#11164 Cancel</a>
                        </div>
                        <div class="section-buttons section-rows">
                            <button type="submit" class="hyperlink_button" name="add-product-button" title='Add new product'>
                                <div class="button-text">Add product</div>
                                <div class="dots-5" style="display: none;"></div>
                            </button>
                        </div>
                        <div class='form-result'></div>
                    </form>
                </div>
    </main>
    <?php include "../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("admin-product-form", "add-product-button", "../../admin_pages/admin_products/admin_products_add_sender.php", "add-product");
        });
    </script> 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateProductImage() {
                var imagePath = document.querySelector("input[name='product_image_path']").value;
                var imageDescription = document.querySelector("textarea[name='product_image_description']").value;

                var productImage = document.querySelector("#image");
                productImage.src = "../../" + imagePath;
                productImage.alt = imageDescription;
            }
            document.querySelector("input[name='product_image_path']").addEventListener('input', updateProductImage);
            document.querySelector("textarea[name='product_image_description']").addEventListener('input', updateProductImage);
        });
    </script>
</body>
</html>