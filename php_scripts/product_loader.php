<?php            
    require_once 'db_connect.php';

    if (isset($_GET['product'])) {
        $productId = $_GET['product'];
        $query = "SELECT 
            Product.id as product_id, 
            Product.product_name, 
            Product.product_description_long as product_description,
            Product.product_price, 
            Supplier.supplier_name,
            Inventory.product_quantity as quantity
        FROM Product 
        JOIN Supplier ON Product.supplier_id = Supplier.id
        LEFT JOIN Inventory ON Product.id = Inventory.product_id
        WHERE Product.id = $productId";

        $imageQuery = "SELECT product_image_path, image_description 
        FROM Product_Image 
        WHERE product_id = $productId";

        if ($result = $conn->query($query)) {
            $info = $result->fetch_assoc();

            // Image display
            $imageResult = $conn->query($imageQuery);
            $images = $imageResult ? $imageResult->fetch_all(MYSQLI_ASSOC) : [];
            $numImages = count($images);
            $mainSliderWidth = 550 * $numImages;
            $iconSliderWidth = 110 * $numImages;

            echo "<div class='section-image-display'>";
            if ($numImages > 0) {
                echo "<div class='main-image-displayer'><div class='main-image-slider' style='width: {$mainSliderWidth}px;'>";
                foreach ($images as $imageRow) {
                    echo "<img src='" . htmlspecialchars($imageRow['product_image_path']) . "' alt='" . htmlspecialchars($imageRow['image_description']) . "'>";
                }
                echo "</div></div>";

                echo "<div class='icon-image-displayer'><div class='icon-image-slider' style='width: {$iconSliderWidth}px;'>";
                foreach ($images as $imageRow) {
                    echo "<img src='" . htmlspecialchars($imageRow['product_image_path']) . "' alt='" . htmlspecialchars($imageRow['image_description']) . "'>";
                }
                echo "</div></div>";
            }
            echo "</div>";

            // Section content
            echo "<div class='section-content'>";
                echo "<div class='section-content-description'>";
                // Review section: TO BE ADDED
                echo "<div class='section-review'><h4>There will be a star grade section</h4></div>";
                echo "<h1>" . htmlspecialchars($info['product_name']) . "</h1>";
                // Inventory - checking if products are in stock
                $notEmptyInventory = true;
                if($info['quantity'] <= 0 || empty($info['quantity'])) {
                    $notEmptyInventory = false;
                    echo "<h3>Out of stock</h3>";
                }
                else {
                    echo "<h3>In stock: " . htmlspecialchars($info['quantity']) . "</h3>";  
                }
                echo "<h2>" . htmlspecialchars($info['product_price']) . " PLN </h2>";
                echo "<div class='product-description'>";
                    echo "<h4>Product's description</h4>";
                    echo "<span>" . htmlspecialchars($info['product_description']) . "</span>";
                echo "</div>";
            echo "</div>";

            // Buttons section
            echo "<div class='section-content-action'>";
                echo "<div class='quantity-button'>";
                if($notEmptyInventory == true) {
                    echo "<button id='decrease-quantity-button' class='hyperlink_button_reverse' type='submit'>-</button>";
                    echo "<input type='number' id='product-quantity' class='transparent_background' value='1' min='1' max='" . htmlspecialchars($info['quantity']) . "' readonly>";
                    echo "<button id='increase-quantity-button' class='hyperlink_button_reverse' type='submit'>+</button>";
                    echo "</div>";
                    echo "<button class='hyperlink_button' type='sumbit'>ADD TO CART</button>";
                }
                else {
                    echo "<button id='decrease-quantity-button' class='hyperlink_button_reverse' disabled>-</button>";
                    echo "<input type='number' id='product-quantity' class='transparent_background' value='0' min='0' max='0' readonly>";
                    echo "<button id='increase-quantity-button' class='hyperlink_button_reverse' disabled>+</button>";
                    echo "</div>";
                    echo "<button class='hyperlink_button' type='sumbit' disabled>OUT OF STOCK</button>";
                }
            echo "</div>";
            echo "</div>";
        }
        else {
            echo "Error while loading product: " . $conn->error;
        }
    } else {
        echo "The ID product was not set";
    }
?>
