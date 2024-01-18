<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<div id='admin-product-section'>";
    echo "<div class='section-header'>";
        echo "<h1>Product details</h1>";
        echo "<button class='hyperlink_button' title='/admin_pages/admin_products/admin_products_add.php' onclick='window.location.href=`../../admin_pages/admin_products/admin_products_add.php`'>Add new product</button>";
        echo "<div class='section-information section-rows'>";
            echo "<h3 class='product-image'>Image</h3>";
            echo "<h3 class='product-name'>Name</h3>";
            echo "<h3 class='product-category'>Category</h3>";
            echo "<h3 class='product-supplier'>Supplier</h3>";
            echo "<h3 class='product-price'>Price ($)</h3>";
            echo "<h3 class='product-quantity'>Qnt.</h3>";
        echo "</div>";
    echo "</div>";
    echo "<hr class='outer'>";
    echo "<div class='section-content'>";
    
    // All product records
    $productQuery = "SELECT * FROM product";
    $productResult = $conn->query($productQuery);
    if ($productResult->num_rows > 0) {

        // All categories
        $categoryQuery = "SELECT * FROM Category";
        $categoryResult = $conn->query($categoryQuery);

        // All suppliers
        $supplierQuery = "SELECT * FROM Supplier";
        $supplierResult = $conn->query($supplierQuery);

        while($product = $productResult->fetch_assoc()) {

            // Category name
            $category = ($conn->query("SELECT category_name FROM category WHERE id = " . $product['category_id']))->fetch_assoc();
            // Supplier name
            $supplier = ($conn->query("SELECT supplier_name FROM supplier WHERE id = " . $product['supplier_id']))->fetch_assoc();
            // Product's image and image description
            $stmt = $conn->prepare("SELECT product_image_path, image_description FROM Product_Image WHERE product_id = ?");
            $stmt->bind_param("i", $product['id']);
            $stmt->execute();
            $imageResult = $stmt->get_result();
            $image = $imageResult->fetch_assoc();
            // Product's inventory
            $inventory = ($conn->query("SELECT product_quantity FROM inventory WHERE product_id = " . $product['id']))->fetch_assoc();

            echo "<form id='admin-product-form' action='../../admin_pages/admin_products/admin_products_edit_sender.php' class='section-element section-columns white-background default-box-shadow' method='post'>";
                echo "<div class='section-information section-rows'>";
                    // Product image
                    echo "<img class='product-image' src='../../" . htmlspecialchars($image['product_image_path']) . "' alt='" . htmlspecialchars($image['image_description']) . "' title='" . htmlspecialchars($image['image_description']) . "'></img>";
                    // Product name
                    echo "<input type='text' class='product-name' name='product_name' maxlength='100' required placeholder='" . htmlspecialchars($product['product_name']) . "' value='" . htmlspecialchars($product['product_name']) . "'>";
                    // Category name
                    echo "<select class='product-category' name='product_category' required>";
                        while($category = $categoryResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($category['id']) . "'>" . htmlspecialchars($category['category_name']) . "</option>";
                        }
                    echo "</select>";
                    // Supplier name
                    echo "<select class='product-supplier' name='product_supplier' required>";
                        while($supplier = $supplierResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($supplier['id']) . "'>" . htmlspecialchars($supplier['supplier_name']) . "</option>";
                        }
                    echo "</select>";
                    // Product price
                    echo "<input type='number' class='product-price' name='product_price' min='0' step='0.01' required placeholder='" . htmlspecialchars($product['product_price']) . "' value='" . htmlspecialchars($product['product_price']) . "'>";
                    // Quantity
                    echo "<input type='number' class='product-quantity' name='product_quantity' min='0' step='1' required placeholder='" . htmlspecialchars($inventory['product_quantity']) . "' value='" . htmlspecialchars($inventory['product_quantity']) . "'>";
                echo "</div>";
                echo "<label for='product_image_path' class='product-image-path'>";
                    echo "<h3>Product image path</h3>";
                    // Product's image path and image description
                    echo "<input type='text' class='product-image-path' name='product_image_path' maxlength='200' required placeholder='" . htmlspecialchars($image['product_image_path']) . "' value='" . htmlspecialchars($image['product_image_path']) . "'>";
                    echo "<h3>Product image description</h3>";
                    echo "<textarea name='product_image_description' required placeholder='" . htmlspecialchars($image['image_description']) . "'>" . htmlspecialchars($image['image_description']) . "</textarea>";
                echo "</label>";
                    // Product's description
                echo "<label for='product-description' class='product-description'>";
                    echo "<h3>Product description</h3>";
                    echo "<textarea name='product_description' required placeholder='" . htmlspecialchars($product['product_description_long']) . "'>" . htmlspecialchars($product['product_description_long']) . "</textarea>";
                echo "</label>";
                echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($product['id']) . "'>";
                echo "<div class='section-buttons section-rows'>";
                    echo "<button class='edit-button hyperlink_button' type='submit' title='Edit product details'>Edit product details</button>";
                    echo "<button type='button' class='remove-button hyperlink_button_reverse' title='Remove product' product-id='". htmlspecialchars($product['id']) ."'>X</button>";
                echo "</div>";
                echo "<div class='form-result' product-id='". htmlspecialchars($product['id']) ."'></div>";
            echo "</form>";
        }
    } else {
        echo"<h4 class='empty'>No products</h4>";
    }
$conn->close();
?>
