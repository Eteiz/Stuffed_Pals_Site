<?php
                
require_once 'php_scripts/db_connect.php';

$query = "SELECT Product.id as product_id, Product.product_name, Product.product_price, Supplier.supplier_name, 
          (SELECT product_image_path FROM Product_Image WHERE Product_Image.product_id = Product.id LIMIT 1) as image_path
          FROM Product 
          JOIN Supplier ON Product.supplier_id = Supplier.id"; // Adjust the query as needed based on your actual table and column names

if ($result = $conn->query($query)) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        // 4 is the number of products in the row
        if ($count % 4 == 0) {
            echo $count > 0 ? "</div>" : "";
            echo "<div class='product-row'>";
        }
        echo "<div class='product'>";
            if (!empty($row['image_path'])) {
                echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Product Image'>";
            } else {
                echo "<img src='img/placeholder.png' alt='No image available'>";
            }
            echo "<div class='product-description'>";
                echo "<span>" . htmlspecialchars($row['supplier_name']) . "</span>";
                echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<h4>" . htmlspecialchars($row['product_price']) . " PLN </h4>";
            echo "</div>";
            echo "<button class='hyperlink_button'>ADD TO CART</button>";
        echo "</div>";
        $count++;
    }
    echo "</div>";
} else {
    echo "Błąd podczas pobierania produktów: " . $conn->error;
}
?>
