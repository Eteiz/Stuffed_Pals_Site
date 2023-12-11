<?php
require_once "../init.php";
if (!is_user_logged_in()) {
    header('Location: ../user_pages/user_login/login_page.php');
    exit;
}

$userId = $_SESSION['user_id'];

$cartIdQuery = $conn->prepare("SELECT id FROM cart WHERE user_id = ?");
$cartIdQuery->bind_param("i", $userId);
$cartIdQuery->execute();
$cartIdResult = $cartIdQuery->get_result();
if ($cartIdRow = $cartIdResult->fetch_assoc()) {
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
        echo "<h4> Product id: " . htmlspecialchars($row['product_id']) . "</h4>";
        echo "</div></div>";

        echo "<div class='quantity-button'>";
        echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>-</button>";
        $maxQuantity = isset($row['product_quantity']) ? $row['product_quantity'] : 5;
        echo "<input type='number' class='product-quantity transparent_background' data-product-id='" . $row['product_id'] . "' value='" . $row['quantity'] . "' min='1' max='" . $maxQuantity . "'>";
        echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>+</button>";
        echo "</div>";

        $totalPrice = $row['quantity'] * $row['product_price'];
        echo "<h3> $" . $totalPrice . " </h3>";
        echo "<button class='delete-button hyperlink_button_reverse' data-product-id='" . $row['product_id'] . "'>X</button>";
        echo "</form><hr>";
    }
} else {
    echo "Cart not found.";
}
$conn->close();
?>