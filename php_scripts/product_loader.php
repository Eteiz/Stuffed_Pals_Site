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
            Inventory.product_quantity as quantity,
            (SELECT Product_Image.product_image_path 
            FROM Product_Image 
            WHERE Product_Image.product_id = Product.id LIMIT 1) as image_path,
            (SELECT Product_Image.image_description 
            FROM Product_Image 
            WHERE Product_Image.product_id = Product.id LIMIT 1) as image_description
        FROM Product 
        JOIN Category ON Product.supplier_id = Supplier.id;
        JOIN Inventory ON Product.id = Inventory.id;
        WHERE Product.id = $productId;"

        if ($result = $conn->query($query)) {
            $info = $result->fetch_assoc();

            // Image display: TO BE ADDED
            echo "<div class='section-image-display'>";
                $imagePath = $info['image_path'];
                if (!empty($info['image_path']) && file_exists($imagePath)) {
                    echo "<img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($info['image_description']) . "'>";
                } else {
                    // Placeholder image
                    echo "<img src='../assets/placeholder.png' alt='No image available'>";
                }
            echo "</div>";
            // Section content
            echo "<div class='section-content'>";
                echo "<div class="section-content-description">";
                // Review section: TO BE ADDED
                echo "<div class='section-review'><h4>There will be a star grade section</h4></div>"
                echo "<h1>" . htmlspecialchars($info['product_name']) . "</h1>";
                // <h3>In Stock: 6</h3> //
                echo "<h2>" . htmlspecialchars($info['product_price']) . "</h2>";
                echo "<div class='product-description'>";
                    echo "<h4>Product's description</h4>";
                    echo "<span>" . htmlspecialchars($info['product_description']) . "</span>";
                echo "</div>";
            echo "</div>";
            // Buttons section
            echo "<div class='section-content-action'>";
                echo "<div class='quantity-button'>";
        }
        else {
            echo "Error while loading product: " . $conn->error;
        }


    } else {
        echo "The ID product was not set";
    }
?>