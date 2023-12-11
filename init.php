<?php
require_once 'config.php';
session_start();

//============================ USER FUNCTION ============================//
if (!isset($_SESSION['user_logged']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_login'])) {
    $_SESSION['user_logged'] = false;
	$_SESSION['user_id'] = NULL;
    $_SESSION['user_login'] = NULL;
}

function is_user_logged_in() {
    return isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true && isset($_SESSION['user_id']) && $_SESSION['user_id'];
}

function log_user_out() {
        unset($_SESSION['user_logged']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_login']);
        session_destroy();
        header('Location: ../../index.php');
        exit;
}

//============================ CART FUNCTION ============================//
function addProductToCart($userId, $productId, $quantity) {
    global $conn;

    // Checking if the cart already exists
    $cartId = getCartId($userId);
    if ($cartId === null) {
        $cartId = createCart($userId);
    }

    // Checking if the product is already in the cart
    $sql = "SELECT quantity FROM cart_item WHERE cart_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentQuantityInCart = 0;

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $currentQuantityInCart = $row['quantity'];
        } else {
            $currentQuantityInCart = 0;
        }
    }

    // Fetching the product quantity from inventory
    $sql = "SELECT product_quantity FROM Inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $inventoryResult = $stmt->get_result();

    if ($inventoryRow = $inventoryResult->fetch_assoc()) {
        $availableQuantity = $inventoryRow['product_quantity'];

        $totalQuantity = $currentQuantityInCart + $quantity;
        if ($totalQuantity > $availableQuantity) {
            // If the product quantity in the cart exceeds the one in inventory, the product quantity in the cart is changed
            $totalQuantity = $availableQuantity;
            $adjusted = true;
        }

        // Checking if the product was added before
        if ($currentQuantityInCart > 0) {
            $sql = "UPDATE cart_item SET quantity = ? WHERE cart_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $totalQuantity, $cartId, $productId);
        } else {
            $sql = "INSERT INTO cart_item (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $cartId, $productId, $quantity);
        }

        $stmt->execute();
        if (isset($adjusted) && $adjusted === true) {
            return (["status" => 1, "msg" => "Product successfully added to cart. Quantity adjusted to maximum available stock (" . $availableQuantity . ")."]);
        } else {
            return (["status" => 1, "msg" => "Product successfully added to cart."]);
        }
    } else {
        return (["status" => 0, "msg" => "Product not found in inventory"]);
    }
}

// Function that checks if the cart was already created for the user
function getCartId($userId) {
    global $conn;

    $sql = "SELECT id FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['id'];
    }
    return null;
}

// Function that creates cart
function createCart($userId) {
    global $conn;

    $sql = "INSERT INTO cart (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    return $conn->insert_id;
}

function isCartExist($userId) {
    if(!is_user_logged_in()) return false;
    global $conn;

    $sql = "SELECT COUNT(*) FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    return $row[0] > 0;
}
?>