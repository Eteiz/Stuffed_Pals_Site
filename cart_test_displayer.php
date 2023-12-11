<?php
require_once './init.php';


$cartId = getCartId($_SESSION['user_id']);
$sql = "SELECT Product.product_name, cart_item.quantity FROM cart_item INNER JOIN Product ON cart_item.product_id = Product.id WHERE cart_item.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cartId);
$stmt->execute();
$result = $stmt->get_result();

// Wyświetlanie produktów
while ($row = $result->fetch_assoc()) {
    echo "<div>";
    echo "<h1>" . htmlspecialchars($row['product_name']) . "</h1>";
    echo "<h3> Quantity: " . htmlspecialchars($row['quantity']) . "</h3>";
    echo "</div>";
}
$stmt->close();
?>