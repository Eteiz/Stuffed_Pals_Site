<?php            
    require_once "../config.php";

    $selectedCategory = isset($_GET["category"]) ? $_GET["category"] : null;

    $query = "CALL GetProductCategories";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $categoryName = htmlspecialchars($row["category_name"]);
            $productCount = $row["product_count"];

            $isChecked = ($categoryName === $selectedCategory) ? " checked" : "";
            echo "<label><input type='checkbox' name='product_category[]' value='" . $categoryName . "'" . $isChecked . "> " . $categoryName . " <span style='font-size: 17px; color: var(--primary-color);'>(" . $productCount . ")</span></label>";
        }
        $result->free();
        $conn->next_result();
    } else {
        echo "<h4> Error while loading categories</h4>";
    }
?>