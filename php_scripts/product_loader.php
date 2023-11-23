<?php            
    require_once 'db_connect.php';
    
    // Total number of products
    $totalProductsQuery = "SELECT COUNT(*) as total_count FROM Product";
    $totalProductsResult = $conn->query($totalProductsQuery);
    $totalProductsRow = $totalProductsResult->fetch_assoc();
    $totalProductsCount = $totalProductsRow['total_count'];

    // Main query
    $query = "SELECT 
        Product.id as product_id, 
        Product.product_name, 
        Product.product_price, 
        Category.category_name,
        (SELECT Product_Image.product_image_path 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_path,
        (SELECT Product_Image.image_description 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_description
    FROM Product 
    JOIN Category ON Product.category_id = Category.id";
                
    $whereClauses = [];
    $orderClause = "";
                
    // Min, max value
    $minPriceSet = isset($_POST['price-min']) && $_POST['price-min'] !== '';
    $maxPriceSet = isset($_POST['price-max']) && $_POST['price-max'] !== '';
    if ($minPriceSet) {
        $whereClauses[] = "Product.product_price >= " . intval($_POST['price-min']);
    }
    if ($maxPriceSet) {
        $whereClauses[] = "Product.product_price <= " . intval($_POST['price-max']);
    }
                
    // Categories
    if (!empty($_POST['product_category'])) {
        $categoryFilters = array_map(function($cat) { 
            return "'" . $cat . "'"; 
        }, $_POST['product_category']);
        
        if (!empty($categoryFilters)) {
            $whereClauses[] = "Category.category_name IN (" . implode(", ", $categoryFilters) . ")";
        }
    }
    
    // Where clause
    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }
                
    // Sorting
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
            // TBA: DATE
        }
    } 
    else {
        // Default sorting
        $orderClause = " ORDER BY Product.id ASC";
    }
    $query .= $orderClause;


    // Counting the number of displayed products
    $countQuery = "SELECT COUNT(*) as product_count 
    FROM Product 
    JOIN Category ON Product.category_id = Category.id";

    if (!empty($whereClauses)) {
        $countQuery .= " WHERE " . implode(" AND ", $whereClauses);
    }
    $countResult = $conn->query($countQuery);
    if ($countResult) {
        $countRow = $countResult->fetch_assoc();
        $productCount = $countRow['product_count']; 
    } 
    else {
        echo "Error while counting products: " . $conn->error;
    }
                
    // Creating list of products
    if ($result = $conn->query($query)) {
        $count = 0;
        //echo "<h4>Displaying " . $productCount . " of " . $totalProductsCount . " products</h4>";
        while ($row = $result->fetch_assoc()) {
            if ($count % 4 == 0) {
                echo $count > 0 ? "</div>" : ""; 
                echo "<div class='product-row'>";
            }
            echo "<div class='product white_background'>";
            if (!empty($row['image_path']) && !empty($row['image_description'])) {
                echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['image_description']) . "'>";
            } 
            else {
                // Placeholder image
                echo "<img src='../assets/placeholder.png' alt='No image available'>";
            }
            echo "<div class='product-description'>";
                echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<span> Lorem ipsum dolor sit amet, sed do eiusmod tempor. </span>";
            echo "</div>";
            echo "<div class='product-action'>";
            echo "<h4>" . htmlspecialchars($row['product_price']) . " PLN </h4>";
            echo "<button class='hyperlink_button'>ADD TO CART</button>";
            echo "</div>";
            echo "</div>";
            $count++;
        }
        if ($count > 0) { echo "</div>"; }
    } 
    else {
        echo "Error while displaying products: " . $conn->error;
    }
?>