<?php            
    require_once "../config.php";

    if ($conn->multi_query("CALL GetProductAvailability()")) {
        $isFirstQuery = true;
        do {
            if ($result = $conn->store_result()) {
                while ($row = $result->fetch_assoc()) {
                    if ($isFirstQuery) {
                        $availableCount = $row["available_count"];
                    } else {
                        $outOfStockCount = $row["out_of_stock_count"];
                    }
                }
                $result->free();
            }
            $isFirstQuery = false;
        } while ($conn->next_result());
        echo "<label><input type='checkbox' name='product_status[]' value='available'> Available <span style='font-size: 17px; color: var(--primary-color);'>(" . $availableCount . ")</span></label>";
        echo "<label><input type='checkbox' name='product_status[]' value='out_of_stock'> Out of Stock <span style='font-size: 17px; color: var(--primary-color);'>(" . $outOfStockCount . ")</span></label>";
    } else {
        echo "<h4> Error while loading availability</h4>";
    }
?>