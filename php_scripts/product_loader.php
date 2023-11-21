<?php            
    require_once 'db_connect.php';
    $query = "SELECT 
        Product.id as product_id, 
        Product.product_name, 
        Product.product_price, 
        Supplier.supplier_name, 
        Category.category_name,
        (SELECT Product_Image.product_image_path 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_path,
        (SELECT Product_Image.image_description 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_description
    FROM Product 
    JOIN Supplier ON Product.supplier_id = Supplier.id
    JOIN Category ON Product.category_id = Category.id"; // Dołączenie tabeli Category
                
    $whereClauses = [];
    $orderClause = "";
                
    // Filtrowanie według ceny
    $minPriceSet = isset($_POST['price-min']) && $_POST['price-min'] !== '';
    $maxPriceSet = isset($_POST['price-max']) && $_POST['price-max'] !== '';
    if ($minPriceSet) {
        $whereClauses[] = "Product.product_price >= " . intval($_POST['price-min']);
    }
    if ($maxPriceSet) {
        $whereClauses[] = "Product.product_price <= " . intval($_POST['price-max']);
    }
                
    // Filtrowanie według kategorii
    if (!empty($_POST['product_category'])) {
        // Przygotuj wartości kategorii do użycia w zapytaniu SQL
        $categoryFilters = array_map(function($cat) { 
            return "'" . $cat . "'"; 
        }, $_POST['product_category']);
        
        if (!empty($categoryFilters)) {
            $whereClauses[] = "Category.category_name IN (" . implode(", ", $categoryFilters) . ")";
        }
    }
    
    // Dodanie klauzul WHERE
    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }
                
    // Sortowanie
    if (isset($_POST['product_sort']) && $_POST['product_sort'] !== '') {
        switch ($_POST['product_sort']) {
            case 'price_asc':
                $orderClause = " ORDER BY Product.product_price ASC";
                break;
            case 'price_desc':
                $orderClause = " ORDER BY Product.product_price DESC";
                break;
            case 'alpha_asc':
                $orderClause = " ORDER BY Product.product_name ASC";
                break;
            case 'alpha_desc':
                $orderClause = " ORDER BY Product.product_name DESC";
                break;
        }
    } else {
        $orderClause = " ORDER BY Product.id ASC";
    }
    $query .= $orderClause;
                
    // Wykonanie zapytania
    if ($result = $conn->query($query)) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count % 4 == 0) {
                echo $count > 0 ? "</div>" : ""; 
                echo "<div class='product-row'>";
            }
            echo "<div class='product'>";
            if (!empty($row['image_path']) && !empty($row['image_description'])) {
                echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['image_description']) . "'>";
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
        if ($count > 0) { echo "</div>"; }
    } 
    else {
        echo "Błąd podczas pobierania produktów: " . $conn->error;
    }
?>