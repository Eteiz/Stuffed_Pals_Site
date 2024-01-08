<?php
require_once "config.php";
session_start();

//============================ USER FUNCTION ============================//
if (!isset($_SESSION["user_logged"]) && !isset($_SESSION["user_id"]) && !isset($_SESSION["user_login"])) {
    $_SESSION["user_logged"] = false;
	$_SESSION["user_id"] = NULL;
    $_SESSION["user_login"] = NULL;
}

function is_user_logged_in() {
    return isset($_SESSION["user_logged"]) && 
       is_bool($_SESSION["user_logged"]) &&
       $_SESSION["user_logged"] === true && 
       isset($_SESSION["user_id"]) && 
       $_SESSION["user_id"] >= 0 &&
       is_numeric($_SESSION["user_id"]);
}

function log_user_out() {
        unset($_SESSION["user_logged"]);
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_login"]);
        session_destroy();
}

//============================ CART FUNCTION ============================//
// 0 - Status: Ok
// 1 - Status: Error while taking action, incorrect parameters / invalid action
// 2 - Status: User not logged in

function addProductToCart($userId, $productId, $quantity) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."];
    // Checking if the parameters are correct
    if(!$productId || !$quantity || $quantity <= 0) return ["status" => 1, "msg" => "Incorrect product parameters."];

    global $conn;

    // Checking if the cart already exists - if not creating a new one
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
            $currentQuantityInCart = $row["quantity"];
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
        $availableQuantity = $inventoryRow["product_quantity"];

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

        if($stmt->execute()) {
            if (isset($adjusted) && $adjusted === true) {
                return ["status" => 0, "msg" => "Product maximum quantity reached. Quantity in cart adjusted to maximum available stock (" . $availableQuantity . ")."];
            } else {
                return ["status" => 0, "msg" => "Product successfully added to cart."];
            }
        } else {
            return ["status" => 1, "msg" => "Error updating product quantity."];
        }
    } else {
        return ["status" => 1, "msg" => "Product not found in inventory."];
    }
}

function subtractProductFromCart($userId, $productId, $quantity) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."] ;
    // Checking if the parameters are correct
    if(!$productId || !$quantity || $quantity <= 0) return ["status" => 1, "msg" => "Incorrect product parameters."];

    global $conn;

    // Fetching cart value
    $cartId = getCartId($userId);
    if ($cartId === null) {
        return ["status" => 1, "msg" => "Cart not found."];
    }

    // Fetching the product quantity from cart_item
    $sql = "SELECT quantity FROM cart_item WHERE cart_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();
    $cartResult = $stmt->get_result();

    if($row = $cartResult->fetch_assoc()) {
        $currentQuantityInCart = $row["quantity"];
        $newQuantity = $currentQuantityInCart - $quantity;

        // If new quantity is equal or below 0, remove product from the cart
        if ($newQuantity <= 0) {
            return removeProductFromCart($userId, $productId);
        } else {
            $sql = "UPDATE cart_item SET quantity = ? WHERE cart_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $newQuantity, $cartId, $productId);

            if ($stmt->execute()) {
                return ["status" => 0, "msg" => "Product successfully subtracted from cart."];
            } else {
                return ["status" => 1, "msg" => "Error updating product quantity."];
            }
         }
    } else {
        return ["status" => 1, "msg" => "Product not found in cart."];
    }
}

function removeProductFromCart($userId, $productId) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."];
     // Checking if the parameters are correct
    if(!$productId) return ["status" => 1, "msg" => "Incorrect product parameters."];
    
    global $conn;

    // Fetching cart value
    $cartId = getCartId($userId);
    if ($cartId === null) {
        return ["status" => 1, "msg" => "Cart not found."];
    }

    // Deleting product from cart
    $sql = "DELETE FROM cart_item WHERE cart_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cartId, $productId);

    if ($stmt->execute()) {
        return ["status" => 0, "msg" => "Product successfully removed from cart."];
    } else {
        return ["status" => 1, "msg" => "Error removing product from cart."];
    }
}

function updateProductFromCart($userId, $productId, $quantity) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."] ;
    // Checking if the parameters are correct
    if(!$productId || $quantity < 0) return ["status" => 1, "msg" => "Incorrect product parameters."];
    
    global $conn;
    
    // Fetching cart value
    $cartId = getCartId($userId);
     if ($cartId === null) {
        return ["status" => 1, "msg" => "Cart not found."];
    }

    // Fetching the product quantity from Inventory
    $sql = "SELECT product_quantity FROM inventory WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $inventoryResult = $stmt->get_result();

    if ($inventoryRow = $inventoryResult->fetch_assoc()) {
        $availableQuantity = $inventoryRow["product_quantity"];

        // Checking if updated quantity is equal or below 0
        if ($quantity == 0) {
            return removeProductFromCart($userId, $productId);
        }
        // Checking if updated quantity is above quantity in inventory
        if ($quantity > $availableQuantity) {
            if ($availableQuantity > 0) {
                $quantity = $availableQuantity;
            } else {
                return ["status" => 1, "msg" => "Product is out of stock."];
            }
        }
        // Upadting product quantity
        $sql = "UPDATE cart_item SET quantity = ? WHERE cart_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $cartId, $productId);
        if ($stmt->execute()) {
            return ["status" => 0, "msg" => "Product quantity updated successfully."];
        } else {
            return ["status" => 1, "msg" => "Error updating product quantity."];
        }
    } else {
        return ["status" => 1, "msg" => "Product not found in inventory."];
    }
}

// Function that checks if the cart was already created for the user
function getCartId($userId) {
    if(!is_user_logged_in()) return null;
    global $conn;

    $sql = "SELECT id FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row["id"];
    }
    return null;
}

// Function that creates cart
function createCart($userId) {
    if(!is_user_logged_in()) return null;
    global $conn;

    $sql = "INSERT INTO cart (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $conn->insert_id;
}

function isCartEmpty($userId) {
    if (!is_user_logged_in()) {return true; }
    global $conn;

    $sql = "SELECT COUNT(cart_item.id) FROM cart
            LEFT JOIN cart_item ON cart.id = cart_item.cart_id
            WHERE cart.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    return $row[0] == 0;
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

//============================ ADDRESS FUNCTION ============================//
// 0 - Status: Ok
// 1 - Status: Error while taking action, incorrect parameters / invalid action
// 2 - Status: User not logged in

function addUserAddress($userId, 
$userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."];
    // Checking if the parameters are correct
    if(!$userFirstName || !$userLastName || !$userEmail || !$userPhoneNumber || !$userHomeAddress || !$userCity || !$userPostalCode || !$userState || !$userCountry) {
        return ["status" => 1, "msg" => "Incorrect address parameters"];
    }
    //return ["status" => 1, "msg" => htmlspecialchars($userFirstName). " " .htmlspecialchars($userLastName). " " .htmlspecialchars($userEmail). " " .htmlspecialchars($userPhoneNumber). " " .htmlspecialchars($userHomeAddress). " " .htmlspecialchars($userCity). " " .htmlspecialchars($userPostalCode). " " .htmlspecialchars($userState). " " .htmlspecialchars($userCountry). " "];
    
    global $conn;
    $sql = "CALL AddUserAddress(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @p_status, @p_message)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssss", $userId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry);
    $stmt->execute();

    $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
    $result = $select->fetch_assoc();
    
    if($result) {
        return ["status" => $result['status'], "msg" => $result['message']];
    } else {
        return ["status" => 1, "msg" => "Error while adding address."];
    }
}

function updateUserAddress($userId, $userAddressId, 
$userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."];
    // Checking if the parameters are correct
    if(!$userAddressId || !is_numeric($userAddressId) || $userAddressId < 0 || !$userFirstName || !$userLastName || !$userEmail || !$userPhoneNumber || !$userHomeAddress || !$userCity || !$userPostalCode || !$userState || !$userCountry) {
        return ["status" => 1, "msg" => "Incorrect address parameters."];
    }

    global $conn;
    $sql = "CALL UpdateUserAddress(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @p_status, @p_message)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssssssss", $userId, $userAddressId, $userFirstName, $userLastName, $userEmail, $userPhoneNumber, $userHomeAddress, $userCity, $userPostalCode, $userState, $userCountry);
    $stmt->execute();

    $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
    $result = $select->fetch_assoc();
    
    // Check if address was updated
    if($result) {
        return ["status" => $result['status'], "msg" => $result['message']];
    } else {
        return ["status" => 1, "msg" => "Error while updating address."];
    }
}

function deleteUserAddress($userId, $userAddressId) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in()) return ["status" => 2, "msg" => "User not logged in."];
    // Checking if the parameters are correct
    if(!$userAddressId || !is_numeric($userAddressId) || $userAddressId < 0) {
        return ["status" => 1, "msg" => "Incorrect address parameters."];
    }

    global $conn;
    $sql = "CALL DeleteUserAddress(?, ?, @p_status, @p_message)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $userAddressId);
    $stmt->execute();

    $select = $conn->query("SELECT @p_status AS status, @p_message AS message");
    $result = $select->fetch_assoc();
    
    // Check if the address was deleted
    if($result) {
        return ["status" => $result['status'], "msg" => $result['message']];
    } else {
        return ["status" => 1, "msg" => "Error while deleting address."];
    } 
}

//============================ ORDER FUNCTION ============================//
// 0 - Status: Ok
// 1 - Status: Error while taking action, incorrect parameters / invalid action
// 2 - Status: User not logged in

function startCartReservation($userId) {
    // Checking if user is logged and user_id is valid
    if(!is_user_logged_in() || !isCartExist($userId)) return null;


}



?>

