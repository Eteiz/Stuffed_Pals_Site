<?php
require_once "../init.php";
$userId = $_SESSION['user_id'];

$cartIdQuery = $conn->prepare("SELECT id FROM cart WHERE user_id = ?");
$cartIdQuery->bind_param("i", $userId);
$cartIdQuery->execute();
$cartIdResult = $cartIdQuery->get_result();

if(isCartEmpty($userId)) {
    // TBA: CHANGE THIS STATUS TO SHOP BUTTON
    echo "<h4>Looks like your cart is currently empty. 
        It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
        Explore our collection and find your next adorable companion 
        </h4>";
}
else if ($cartIdRow = $cartIdResult->fetch_assoc()) {
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

    while ($row = $result->fetch_assoc()) {
        echo "<form class='section-row'>";
        echo "<div class='section-row-image'>";

        $imagePath = "../" . $row["product_image_path"];
        if (!empty($row["product_image_path"]) && file_exists($imagePath)) {
            echo "<img src='" . htmlspecialchars($imagePath) . "' alt='" . htmlspecialchars($row["image_description"]) . "'>";
        } else {
            echo "<img src='../assets/placeholder.png' alt='No image available'>";
        }

        echo "<div class='section-row-image-description'>";
        echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
        echo "<div class='form-result' data-product-id='" . $row['product_id'] . "'>";
            echo "<h4 class='form-result-status'></h4>";
        echo "</div>";
        echo "</div></div>";

        echo "<div class='quantity-button'>";
        echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>-</button>";
        $maxQuantity = isset($row['product_quantity']) ? $row['product_quantity'] : 5;
        echo "<input type='number' class='product-quantity transparent_background' data-product-id='" . $row['product_id'] . "' value='" . $row['quantity'] . "' min='1' max='" . $maxQuantity . "'>";
        echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>+</button>";
        echo "</div>";

        $totalPrice = $row['quantity'] * $row['product_price'];
        echo "<h3 class='price-tag'> $" . $totalPrice . " </h3>";
        echo "<button type='button' class='delete-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>X</button>";
        echo "</form><hr>";
    }
} else {
    // TBA: CHANGE THIS STATUS TO SHOP BUTTON
    echo "<h4>Looks like your cart is currently empty. 
        It's the perfect opportunity to fill it with plushie wonders and bring home some cuddly joy! 
        Explore our collection and find your next adorable companion 
        </h4>";
}
$conn->close();
?>