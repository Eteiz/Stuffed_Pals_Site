<?php
require_once "../init.php";
$userId = $_SESSION['user_id'];

$cartIdQuery = $conn->prepare("SELECT id FROM cart WHERE user_id = ?");
$cartIdQuery->bind_param("i", $userId);
$cartIdQuery->execute();
$cartIdResult = $cartIdQuery->get_result();

$cartQuery = $conn->prepare("CALL UpdateAllCarts()");
$cartQuery->execute();

if(isCartEmpty($userId)) {
    echo "<div id='checkout-empty'>";
        echo "<img src='../assets/icons/cart_big_icon.png' alt='Colorful cart image' title='Colorful cart image'></img>";
        echo "<h1> Your cart is empty! </h1>";
        echo "<h4>";
                echo "Looks like your cart is currently empty. 
                It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
                Explore our collection and find your next adorable companion";
        echo "</h4>";
        echo "<button class='hyperlink_button' onclick='location.href=\"../shop_page/shop.php\"' title='/shop_page/shop.php'>Browse</button>";
    echo "</div>";
}
else if($cartIdRow = $cartIdResult->fetch_assoc()) {

    $cartId = $cartIdRow['id'];

    $query = "SELECT cart_item.product_id, product.product_name, cart_item.quantity, product.product_price, 
                     (SELECT product_image.product_image_path FROM product_image WHERE product_image.product_id = product.id LIMIT 1) as product_image_path,
                     (SELECT product_image.image_description FROM product_image WHERE product_image.product_id = product.id LIMIT 1) as image_description,
                     inventory.product_quantity
              FROM cart_item
              JOIN product ON cart_item.product_id = product.id
              LEFT JOIN inventory ON product.id = inventory.product_id
              WHERE cart_item.cart_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vartiable for storing subtotal price
    $totalPrice = 0.00;

    echo "<div class='product-cart-displayer'>";
        echo "<div class='section-header'>";
            echo "<h1> Shopping cart 🛒 </h1>";
            echo "<br>";
            echo "<div class='section-rows'>";
                echo "<h3 class='product-image'>Product</h3>";
                echo "<h3 class='product-title'>Name</h3>";
                echo "<h3 class='product-price'>Price</h3>";
                echo "<h3 class='quantity-button'>Quantity</h3>";
                echo "<h3 class='product-total-price'>Total subprice</h3>";
                echo "<h3 class='remove-button'></h2>";
            echo "</div>";
           echo "<hr class='outer'>";
        echo "</div>";
        while ($row = $result->fetch_assoc()) {
        echo "<form class='section-element'>";
            echo "<div class='section-rows'>";
                $imagePath = "../" . $row["product_image_path"];
                if (!empty($row["product_image_path"]) && file_exists($imagePath)) {
                    echo "<img class='product-image' src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row["image_description"]) . "' title='" . htmlspecialchars($row["image_description"]) . "'>";
                } else {
                    echo "<img class='product-image' src='../assets/placeholder.png' alt='No image available' title='No image available'>";
                }
                echo "<h4 class='product-title'><a class='hyperlink_text' href='../product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "' title='/product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "'>" . htmlspecialchars($row['product_name']) . "</a></h4>";
                echo "<h4 class='product-price'>$". htmlspecialchars($row['product_price']) ."</h4>";
                echo "<div class='quantity-button section-rows'>";
                    echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "' title='Decrease quantity'>-</button>";
                    $maxQuantity = isset($row['product_quantity']) ? $row['product_quantity'] : 0;
                    echo "<input type='number' class='product-quantity-button white-background' title='Product quantity' data-product-id='" . $row['product_id'] . "' value='" . $row['quantity'] . "' min='1' max='" . $maxQuantity . "'>";
                    echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse' title='Increase quantity' data-product-id='" . $row['product_id'] . "'>+</button>";
                echo "</div>";

                $subtotalPrice = $row['quantity'] * (float)$row['product_price'];
                $subtotalPrice = number_format($subtotalPrice, 2);
                $totalPrice += $subtotalPrice;
                echo "<h4 class='product-total-price'><strong>$" . $subtotalPrice . "</strong></h4>";
                echo "<button type='button' class='remove-button hyperlink_button_reverse' title='Remove product' data-product-id='" . $row['product_id'] . "'>X</button>";
            echo "</div>";
            echo "<div class='form-result' data-product-id='" . $row["product_id"] . "'></div>";
        echo "</form>";
        echo "<hr>";
        }
        echo "</div>";

        // Checkout form 
        $totalPrice = number_format($totalPrice, 2);
        echo "<div class='product-cart-checkout section-columns default-box-shadow'>";
            echo "<h1> Order summary </h1>";
            echo "<span class='section-rows'>";
                echo "<h3> Subtotal </h3>";
                echo "<h4>$" . $totalPrice . "</h4>";
            echo "</span>";
            echo "<span class='section-rows'>";
                echo "<h3> Shipping </h3>";
                echo "<h4> Calculated at checkout</h4>";
            echo "</span>";
            echo "<span class='section-rows'>";
                echo "<h3> Tax </h3>";
                echo "<h4> $0.00 </h4>";
            echo "</span>";
            echo "<span class='section-rows'>";
                echo "<h3 class='highlighted'> Total </h3>";
                echo "<h3 class='highlighted'>$" . $totalPrice . "</h3>";
            echo "</span>";
            echo "<button type='button' class='hyperlink_button' onClick='window.location.href=\"../../checkout_page/checkout_page.php\"' title='/checkout_page/checkout_page.php'>Proceed to checkout</button>";
        echo "</div>";
}
else {
    echo "<div id='checkout-empty'>";
        echo "<img src='../assets/icons/cart_big_icon.png' alt='Colorful cart image' title='Colorful cart image'></img>";
        echo "<h1> Your cart is empty! </h1>";
        echo "<h4>";
                echo "Looks like your cart is currently empty. 
                It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
                Explore our collection and find your next adorable companion";
        echo "</h4>";
        echo "<button class='hyperlink_button' onclick='window.location.href=\"../shop_page/shop.php\"' title='/shop_page/shop.php'>Browse</button>";
    echo "</div>";
}
$conn->close();
?>