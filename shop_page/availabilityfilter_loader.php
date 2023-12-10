<?php            
    require_once "../db_connect.php";

    if ($conn->multi_query("CALL GetProductAvailability()")) {
        do {
            if ($result = $conn->store_result()) {
                while ($row = $result->fetch_assoc()) {
                    if (!isset($availableCount)) {
                        $availableCount = $row["available_count"];
                    } else {
                        $outOfStockCount = $row["out_of_stock_count"];
                    }
                }
                $result->free();
            }
        } while ($conn->next_result());
    } else {
        echo "Error while loading availability: " . $conn->error;
    }
    echo "<label><input type='checkbox' name='product_status[]' value='available'> Available <span style='font-size: 17px; color: var(--primary-color);'>(" . $availableCount . ")</span></label>";
    echo "<label><input type='checkbox' name='product_status[]' value='out_of_stock'> Out of Stock <span style='font-size: 17px; color: var(--primary-color);'>(" . $outOfStockCount . ")</span></label>";
?>