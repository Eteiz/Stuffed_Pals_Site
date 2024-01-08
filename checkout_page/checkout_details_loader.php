<?php
require_once "../init.php";
$userId = $_SESSION['user_id'];

$subtotal = 0;
$shippingCost = 10.00;

$cartQuery = $conn->prepare("SELECT id FROM cart WHERE user_id = ?");
$cartQuery->bind_param("i", $userId);
$cartQuery->execute();
$cartResult = $cartQuery->get_result();
$cartRow = $cartResult->fetch_assoc();

if (!$cartRow) {
    echo "Your cart is empty.";
} else {
    $cartId = $cartRow['id'];

    $itemsQuery = $conn->prepare("SELECT quantity, product_id FROM cart_item WHERE cart_id = ?");
    $itemsQuery->bind_param("i", $cartId);
    $itemsQuery->execute();
    $itemsResult = $itemsQuery->get_result();

    echo "<section class='details-section default-gradient-background'>";
    echo "<div class='section-content'>";
    echo "<h4 style='padding-left: 10px;'>The contents of the finalized order may vary due to unavailability or shortages in stock of certain products:</h4>";
    echo "<hr class='outer'>";

    $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
    $itemsCount = count($items);
    $currentItem = 0;

    foreach ($items as $item) {
        $currentItem++;

        $productQuery = $conn->prepare("SELECT product_name, product_price FROM product WHERE id = ?");
        $productQuery->bind_param("i", $item['product_id']);
        $productQuery->execute();
        $productResult = $productQuery->get_result();
        $product = $productResult->fetch_assoc();

        $imageQuery = $conn->prepare("SELECT product_image_path, image_description FROM product_image WHERE product_id = ? LIMIT 1");
        $imageQuery->bind_param("i", $item['product_id']);
        $imageQuery->execute();
        $imageResult = $imageQuery->get_result();
        $image = $imageResult->fetch_assoc();

        echo '<div class="section-row">';
        $imagePath = isset($image["product_image_path"]) && !empty($image["product_image_path"]) ? "../" . $image["product_image_path"] : '../assets/placeholder.png';
        $altText = isset($image["image_description"]) ? htmlspecialchars($image["image_description"]) : 'No image available';
        echo "<img src='" . htmlspecialchars($imagePath) . "' alt='" . $altText . "'>";
        echo '<span>' . htmlspecialchars($product['product_name']) . ' <strong>x' . $item['quantity'] . '</strong></span>';
        echo '<h4> $' . number_format($product['product_price'] * $item['quantity'], 2) . ' </h4>';
        echo '</div>';

        if ($currentItem < $itemsCount) {
            echo "<hr>";
        }

        $subtotal += $product['product_price'] * $item['quantity'];
    }

    echo '</div>';
    echo '<hr class="outer">';
    echo '<div class="section-footer">';
    echo '<div class="section-row">';
    echo '<span>Subtotal</span>';
    echo '<h4><strong>$' . number_format($subtotal, 2) . '</strong></h4>';
    echo '</div>';
    echo '<div class="section-row">';
    echo '<span>Shipping</span>';
    echo '<h4><strong>$' . number_format($shippingCost, 2) . '</strong></h4>';
    echo '</div>';
    echo '<div class="section-row">';
    echo '<h3>Total</h3>';
    echo '<h3><strong>$' . number_format($subtotal + $shippingCost, 2) . '</strong></h3>';
    echo '</div>';
    echo '</div>';
    echo '</section>';
}

$conn->close();
?>