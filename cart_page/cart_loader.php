<?php
require_once "../init.php";
$userId = $_SESSION['user_id'];

$cartIdQuery = $conn->prepare("SELECT id FROM cart WHERE user_id = ?");
$cartIdQuery->bind_param("i", $userId);
$cartIdQuery->execute();
$cartIdResult = $cartIdQuery->get_result();

if(isCartEmpty($userId)) {
    echo "<article id='checkout-empty'>";
        echo "<img src='../assets/icons/cart_big_icon.png' alt='Colorful cart image'></img>";
        echo "<h1> Your cart is empty! </h1>";
        echo "<h4>";
                echo "Looks like your cart is currently empty. 
                It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
                Explore our collection and find your next adorable companion";
        echo "</h4>";
        echo "<a class='hyperlink_button' href='../shop_page/shop.php'>Browse</a>";
    echo "</article>";
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
    $subtotal = 0.00;
    
    // Checkout List
    echo "<article id='checkout-list'>";
    // Cart title section
    echo "<div class='section-title'>";
        echo "<h1 style='margin-bottom: 30px;'> Shopping cart </h1>";
        echo "<div class='section-title-description'>";
            // Width adjusted to width of cart-item elements
                echo "<h3 style='width: 450px;'>Product</h3>";
                echo "<h3 style='width: 75px;''>Price</h3>";
                echo "<h3 style='width: 125px;'>Quantity</h3>";
                echo "<h3 style='width: 125px;'>Subtotal</h3>";
                echo "<h3 style='width: 50px;'></h3>";
        echo "</div>";
    echo "</div>";
    echo "<hr style='height: 2px;'>";
    // Cart items list
    echo "<div class='section-content'>";

    while ($row = $result->fetch_assoc()) {
        echo "<form class='section-row'>";
            echo "<div class='section-row-image'>";
            echo "<a href='../product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "'>";
            $imagePath = "../" . $row["product_image_path"];
            if (!empty($row["product_image_path"]) && file_exists($imagePath)) {
                echo "<img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row["image_description"]) . "'>";
            } else {
                echo "<img src='../assets/placeholder.png' alt='No image available'>";
            }
            echo "</a>";
        echo "<div class='section-row-image-description'>";
        echo "<h3><a class='hyperlink_text' href='../product_page/product_page.php?product=" . htmlspecialchars($row["product_id"]) . "'>" . htmlspecialchars($row['product_name']) . "</a></h3>";
        echo "<div class='form-result' data-product-id='" . $row["product_id"] . "'></div>";
        echo "</div></div>"; 
        echo "<h4 class='product-price'>$". htmlspecialchars($row['product_price']) ."</h4>";
        echo "<div class='quantity-button'>";
        echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>-</button>";
        $maxQuantity = isset($row['product_quantity']) ? $row['product_quantity'] : 5;
        echo "<input type='number' class='product-quantity transparent_background' data-product-id='" . $row['product_id'] . "' value='" . $row['quantity'] . "' min='1' max='" . $maxQuantity . "'>";
        echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>+</button>";
        echo "</div>";

        $totalPrice = $row['quantity'] * (float)$row['product_price'];
        $totalPrice = number_format($totalPrice, 2);
        $subtotal += $totalPrice;
        echo "<h4 class='product-subtotal'> $" . $totalPrice . " </h4>";
        echo "<button type='button' class='remove-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>X</button>";
        echo "</form><hr>";
    }
    echo "</article>";

    // Checkout Form 
    $shippingCost = ($subtotal >= 250.00) ? 0.00 : 15.00;
    $shippingCost = number_format($shippingCost, 2);

    $subtotal = number_format($subtotal, 2);

    $total = $subtotal + $shippingCost;
    $total = number_format($total, 2);

    echo "<form id='checkout-form' class='white-background default-box-shadow'>";
        echo "<h1 style='width: 90%; margin: 5px auto 5px auto;'>Summary</h1>";
        if($total < 250.00) {
            echo "<div style='width: 90%; font-size: 15px; color: var(--primary-color); margin: 5px auto 5px auto;'>";
            echo "You are eligible for free shipping! Free shipping applies to orders over <strong>$250.00</strong>.";
            echo "</div>";
        }
        echo "<hr style='height: 2px;'>";
        echo "<div class='checkout-form-row'>";
            echo "<h4>Subtotal</h4>";
            echo "<h3>$". htmlspecialchars($subtotal) ."</h3>";
        echo "</div>";
        echo "<div class='checkout-form-row'>";
            echo "<h4>Shipping and handling</h4>";
            echo "<h3>$". htmlspecialchars($shippingCost) ."</h3>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='checkout-form-row'>";
            echo "<h3>Total</h3>";
            echo "<h3>$". htmlspecialchars($total) ."</h3>";
        echo "</div>";
        // Button to procees to checkout
        echo "<button type='button' class='hyperlink_button' onClick='window.location.href=\"../../cart_page/checkout_page.php\"'>Proceed to checkout</button>";
        echo "<h4 style='width: 90%; margin: 5px auto 5px auto;'>We accept:</h4>";
        echo "<div class='checkout-form-row' style='justify-content: flex-start;'>";
            echo "<img src='../assets/icons/visa_icon.png' alt='Visa icon'></img>";
            echo "<img src='../assets/icons/mastercard_icon.png' alt='Mastercard icon'></img>";
            echo "<img src='../assets/icons/paypal_icon.png' alt='Paypal icon'></img>";
        echo "</div>";
    echo "</form>";
} 
else {
    echo "<article id='checkout-empty'>";
        echo "<img src='../assets/icons/cart_big_icon.png' alt='Colorful cart image'></img>";
        echo "<h1> Your cart is empty! </h1>";
        echo "<h4>";
                echo "Looks like your cart is currently empty. 
                It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
                Explore our collection and find your next adorable companion";
        echo "</h4>";
        echo "<a class='hyperlink_button' href='../shop_page/shop.php'>Browse</a>";
    echo "</article>";
}
$conn->close();
?>