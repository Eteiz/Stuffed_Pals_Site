<?php            
    require_once "../db_connect.php";

    $selectedSupplier = isset($_GET["supplier"]) ? $_GET["supplier"] : null;

    $query = "CALL GetProductSuppliers";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $supplierName = htmlspecialchars($row["supplier_name"]);
            $productCount = $row["product_count"];

            $isChecked = ($supplierName === $selectedSupplier) ? " checked" : "";
            echo "<label><input type='checkbox' name='product_supplier[]' value='" . $supplierName . "'" . $isChecked . "> " . $supplierName . " <span style='font-size: 17px; color: var(--primary-color);'>(" . $productCount . ")</span></label>";
        }
        $result->free();
        $conn->next_result();
    } else {
        echo "<h4> Error while loading suppliers</h4>";
    }
?>