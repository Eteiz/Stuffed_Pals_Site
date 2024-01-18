<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<div id='admin-order-section'>";
    echo "<div class='section-header'>";
        echo "<h1>Order details</h1>";
        echo "<div class='section-information section-rows'>";
            echo "<h3 class='order-id'>Id</h3>";
            echo "<h3 class='order-tital'>Total ($)</h3>";
            echo "<h3 class='order-payment'>Payment</h3>";
            echo "<h3 class='order-delivery'>Delivery</h3>";
            echo "<h3 class='order-status'>Status</h3>";
            echo "<h3 class='order-date'>Created</h3>";
        echo "</div>";
    echo "</div>";
    echo "<hr class='outer'>";
    echo"<div class='section-content'>";
    
    $orderQuery = "SELECT * FROM order_details";
    $orderResult = $conn->query($orderQuery);

    if($orderResult->num_rows > 0) {
        while($order = $orderResult->fetch_assoc()) {
            echo "<form id='admin-order-form' action='../../admin_pages/admin_orders/admin_orders_edit_sender.php' class='section-element white-background default-box-shadow' method='post'>";
            echo "<div class='section-information section-rows'>";
                echo "<h4 class='order-id'>" . htmlspecialchars($order['id']) . "</h4>";
                echo "<h4 class='order-tital'>$" . htmlspecialchars($order['order_price']) . "</h4>";
                echo "<h4 class='order-payment'>" . htmlspecialchars($order['order_payment_form']) . "</h4>";
                echo "<h4 class='order-delivery'>" . htmlspecialchars($order['order_delivery']) . "</h4>";
                echo "<input type='text' class='order-status' name='order_status' maxlength='100' value='" . htmlspecialchars($order['order_status']) . "' placeholder='" . htmlspecialchars($order['order_status']) . "'></input>";
                echo "<h4 class='order-date'>" . htmlspecialchars($order['order_created_date']) . "</h4>";
            echo "</div>";
            echo "<hr class='outer'>";
            // Order address
            echo "<div class='section-details section-rows'>";
            $addressQuery = "SELECT * FROM order_address WHERE order_id = " . $order['id'];
            $addressResult = $conn->query($addressQuery);
            $address = $addressResult->fetch_assoc();
            echo "<div class='section-address section columns'>";
                echo "<h4 class='highlighted'>" . htmlspecialchars($address['order_firstname']) . " " . htmlspecialchars($address['order_lastname']) . "</h4>";
                echo "<h4>" . htmlspecialchars($address['order_email']) . "</h4>";
                echo "<h4>" . htmlspecialchars($address['order_phone']) . "</h4>";
                echo "<h4>" . htmlspecialchars($address['order_homeaddress']) . "</h4>";
                echo "<h4>" . htmlspecialchars($address['order_postalcode']) . ", " . htmlspecialchars($address['order_city']) . "</h4>";
                echo "<h4>" . htmlspecialchars($address['order_country']) . "</h4>";
            echo "</div>";
            // Order items
            $itemQuery = "SELECT * FROM order_item WHERE order_id = " . $order['id'];
            $itemResult = $conn->query($itemQuery);
            echo "<div class='section-products'>";

            $itemResults = $itemResult->fetch_all(MYSQLI_ASSOC);
            $lastIndex = count($itemResults) - 1;
            foreach ($itemResults as $index => $item) {
                if ($item['product_id']) {
                    $productQuery = "SELECT product_name FROM product WHERE id = " . $item['product_id'];
                    $productResult = $conn->query($productQuery);
                    $product = $productResult->fetch_assoc();
                    $productName = htmlspecialchars($product['product_name']);
                    $productQuantity = "x" . htmlspecialchars($item['product_quantity']);
                    $productTotalPrice = "$" . htmlspecialchars($item['product_subtotal_price']);
                } else {
                    $productName = "null";
                    $productQuantity = "-";
                    $productTotalPrice = "-";
                }
                echo "<div class='section-element section-rows'>";
                    echo "<h4 class='highlighted product-name'>" . $productName . "</h4>";
                    echo "<h4 class='product-quantity'>" . $productQuantity . "</h4>";
                    echo "<h4 class='product-total'>" . $productTotalPrice . "</h4>";
                echo "</div>";
                if ($index !== $lastIndex) {
                    echo "<hr>";
                }
            }
            echo "</div>";
        echo "</div>";
        echo "<input type='hidden' name='order_id' value='" . htmlspecialchars($order['id']) . "'></input>";
         echo "<hr class='outer'>";
        echo "<button class='edit-button hyperlink_button' type='submit' title='Edit order status'>Edit order status</button>";
        echo "<div class='form-result'></div>";
        echo "</form>";
        }
    }
    else {
        echo"<h4 class='empty'>No orders</h4>";
    }
    echo "</div>"; 
echo "</div>";
$conn->close();
?>