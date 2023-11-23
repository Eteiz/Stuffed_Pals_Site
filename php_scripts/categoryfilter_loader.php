<?php            
    require_once 'db_connect.php';

    $selectedCategory = isset($_GET['selected_category']) ? $_GET['selected_category'] : null;

    $query = "SELECT Category.id, Category.category_name, COUNT(Product.id) AS product_count 
              FROM Category 
              LEFT JOIN Product ON Category.id = Product.category_id 
              GROUP BY Category.id, Category.category_name";

    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $categoryName = htmlspecialchars($row['category_name']);
            $productCount = $row['product_count'];

            $isChecked = ($categoryName === $selectedCategory) ? ' checked' : '';

            echo "<label><input type='checkbox' name='product_category[]' value='" . $categoryName . "'" . $isChecked . "> " . $categoryName . " <span style='font-size: 17px; opacity: 0.7'>(" . $productCount . ")</span></label>";
        }
    } else {
        echo "Błąd podczas pobierania kategorii: " . $conn->error;
    }
?>
