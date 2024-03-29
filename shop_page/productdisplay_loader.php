<?php            
    require_once "../config.php";
    
    // Main query
    $query = "SELECT 
        Product.id as product_id, 
        Product.product_name, 
        Product.product_price,
        Product.date_added,
        Category.category_name,
        Supplier.supplier_name,
        Inventory.product_quantity as quantity,
        (SELECT Product_Image.product_image_path 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_path,
        (SELECT Product_Image.image_description 
        FROM Product_Image 
        WHERE Product_Image.product_id = Product.id LIMIT 1) as image_description
    FROM Product 
    JOIN Category ON Product.category_id = Category.id
    LEFT JOIN Supplier ON Product.supplier_id = Supplier.id
    LEFT JOIN Inventory ON Product.id = Inventory.product_id";
                
    $whereClauses = [];
    $orderClause = "";
                
    // Price Filter
    $minPriceSet = isset($_POST["price-min"]) && $_POST["price-min"] !== "";
    $maxPriceSet = isset($_POST["price-max"]) && $_POST["price-max"] !== "";
    if ($minPriceSet) {
        $whereClauses[] = "Product.product_price >= " . intval($_POST["price-min"]);
    }
    if ($maxPriceSet) {
        $whereClauses[] = "Product.product_price <= " . intval($_POST["price-max"]);
    }
                
    // Category Filter
    if (!empty($_POST["product_category"])) {
        $categoryFilters = array_map(function($cat) { 
            return "'" . $cat . "'"; 
        }, $_POST["product_category"]);
        
        if (!empty($categoryFilters)) {
            $whereClauses[] = "Category.category_name IN (" . implode(", ", $categoryFilters) . ")";
        }
    }

    // Supplier Filter
    if (!empty($_POST["product_supplier"])) {
        $supplierFilters = array_map(function($supplier) {
            return "'" . $supplier . "'";
        }, $_POST["product_supplier"]);
    
        if (!empty($supplierFilters)) {
            $whereClauses[] = "Supplier.supplier_name IN (" . implode(", ", $supplierFilters) . ")";
        }
    }

    // Filtrowanie dostępności
     if (!empty($_POST["product_status"])) {
         $availabilityFilters = $_POST["product_status"];
        $availabilityWhereClauses = [];
    
        if (in_array("available", $availabilityFilters)) {
            $availabilityWhereClauses[] = "Inventory.product_quantity > 0";
        }
        if (in_array("out_of_stock", $availabilityFilters)) {
            $availabilityWhereClauses[] = "(Inventory.product_quantity <= 0 OR Inventory.product_id IS NULL)";
        }
    
        if (!empty($availabilityWhereClauses)) {
            $whereClauses[] = "(" . implode(" OR ", $availabilityWhereClauses) . ")";
        }
    }
    
    // Where clause
    if (!empty($whereClauses)) {
        $query .= " WHERE " . implode(" AND ", $whereClauses);
    }
                
    // Sorting
    if (isset($_POST["product_sort"]) && $_POST["product_sort"] !== "") {
        switch ($_POST["product_sort"]) {
            case "price_asc":
                $orderClause = " ORDER BY Product.product_price ASC";
                break;
            case "price_desc":
                $orderClause = " ORDER BY Product.product_price DESC";
                break;
            case "alpha_asc":
                $orderClause = " ORDER BY Product.product_name ASC";
                break;
            case "alpha_desc":
                $orderClause = " ORDER BY Product.product_name DESC";
                break;
            case "date_newest":
                $orderClause = " ORDER BY Product.date_added DESC";
                break;
            case "date_oldest":
                $orderClause = " ORDER BY Product.date_added ASC";
                break;
        }
    } 
    else {
        // Default sorting
        $orderClause = " ORDER BY Product.id ASC";
    }
    $query .= $orderClause;
         
    // Creating list of products
    if ($result = $conn->query($query)) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<div class='default-box-shadow section-element'>";
                echo "<a href='../product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "'>";
                    $imagePath = "../" . $row["image_path"];
                    if (!empty($row["image_path"]) && file_exists($imagePath)) {
                        echo "<img src='". htmlspecialchars($imagePath) ."' alt='". htmlspecialchars($row["image_description"]) ."' title='/product_page/product_page.php?product=". $row["product_id"] ."'>";
                    } else {
                        // Placeholder image
                        echo "<img src='../assets/placeholder.png' alt='No image available' title='No image available'>";
                    }
                echo "</a>";
                echo "<div class='section-columns'>";
                    echo "<h3 class='product-name'><a class='hyperlink_text' href='../product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "' title='/product_page/product_page.php?product=" . htmlspecialchars($row['product_id']) . "'>" . htmlspecialchars($row['product_name']) . "</a></h3>";
                    echo "<form class='add-to-cart-form section-rows' action='../cart_page/add_to_cart.php' method='post'>";
                        echo "<h3 class='product-price highlighted'>$". htmlspecialchars($row["product_price"]) ."</h3>";
                        if ($row["quantity"] <= 0 || empty($row["quantity"])) {
                            echo "<button name='add-to-cart-button' class='hyperlink_button_inactive' type='submit' disabled title='Out of stock'>OUT OF STOCK</button>";
                        } else {
                            echo "<input type='hidden' name='quantity' value='1'>";
                            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row["product_id"]) . "'>";
                            echo "<button name='add-to-cart-button' class='hyperlink_button' type='submit' title='Add to cart'>Add to cart</button>";
                        }
                    echo "</form>";
                    echo "<div class='form-result'></div>";
                echo "</div>";
            echo "</div>";
        }
    }
    else {
        echo "Error while displaying products: " . $conn->error;
    }
$conn->close();
?>