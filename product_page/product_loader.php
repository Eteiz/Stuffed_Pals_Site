<?php          
    require_once "../db_connect.php";

    $productId = intval($_GET["product"]);
    $stmt = $conn->prepare("CALL GetProductInformation(?)");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $info = $result->fetch_assoc();
    $imageQuery = "SELECT product_image_path, image_description 
                   FROM Product_Image 
                   WHERE product_id = ?";
    $stmt = $conn->prepare($imageQuery);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $imageResult = $stmt->get_result();
    $stmt->close();

    $images = $imageResult ? $imageResult->fetch_all(MYSQLI_ASSOC) : [];
    $numImages = count($images);
    $mainSliderWidth = 550;
    $iconSliderWidth = 110;

    // Product images
    echo "<div class='section-image-display'>";
    if ($numImages > 0) {
        echo "<div class='main-image-displayer'><div class='main-image-slider' style='width:" . ($mainSliderWidth * $numImages) . "px;'>";
        foreach ($images as $imageRow) {
            echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "'>";
        }
        echo "</div></div>";
        echo "<div class='icon-image-displayer'><div class='icon-image-slider' style='width:" . ($iconSliderWidth * $numImages) . "px;'>";
        foreach ($images as $imageRow) {
            echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "'>";
        }
        echo "</div></div>";
    }
    else {
        echo "<div class='main-image-displayer'><div class='main-image-slider' style='width: {$mainSliderWidth}px;'>";
            echo "<img src='../assets/placeholder.png' alt='Placeholder image'>";
        echo "</div></div>";
        echo "<div class='icon-image-displayer'><div class='icon-image-slider' style='width: {$iconSliderWidth}px;'>";
            echo "<img src='../assets/placeholder.png' alt='Placeholder image'>";
        echo "</div></div>"; 
    }
    echo "</div>";

    // Product information
    echo "<div class='section-content'>";
    echo "<div class='section-content-description'>";
        echo "<h3>". htmlspecialchars($info["supplier_name"]) ."</h3>";
        echo "<h1>" . htmlspecialchars($info["product_name"]) . "</h1>";
        // Availability
        $notEmptyInventory = $info["quantity"] > 0;
        echo "<h4>" . htmlspecialchars($info["product_description"]) . "</h4>";
        echo "<ul>";
            echo "<li>The materials used for crafting are safe for the environment</li>";
            echo "<li>Tailored to meet individual preferences</li>";
            echo "<li>Designed with meticulous attention to detail and to ensure durability</li>";
        echo "</ul>";
    echo "</div>";
    echo "<div class='section-content-action'>";
        echo "<div class='section-content-action-description'>";
            // Review section
            echo "<div class='review-section'>";
                echo "There will be review section";
            echo "</div>";
            echo "<h2> $" . htmlspecialchars($info["product_price"]) ."</h2>";
        echo "</div>";
        echo "<form class='add-to-cart-form section-content-action-buttons' action='../cart_page/add_to_cart.php' method='post'>";
            echo "<div class='quantity-button'>";
                if($notEmptyInventory) {
                    echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse'>-</button>";
                    echo "<input type='number' name='quantity' class='product-quantity transparent_background' value='1' min='1' max='" . htmlspecialchars($info["quantity"]) . "'>";
                    echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse'>+</button>";
                    echo "</div>";
                    echo "<input type='hidden' name='product_id' value='" . $productId . "'>";
                    echo "<button name='add-to-cart-button' class='hyperlink_button' type='submit'>ADD TO CART <div class='dots-5' style='display: none;'></div></button>";
                } else {
                    echo "<button type='button' class='decrease-quantity-button hyperlink_button_reverse_inactive' disabled>-</button>";
                    echo "<input type='number' class='product-quantity transparent_background' value='0' min='0' max='0' readonly style='border-color: var(--action-color-disabled);'>";
                    echo "<button type='button' class='increase-quantity-button hyperlink_button_reverse_inactive' disabled>+</button>";
                    echo "</div>";
                    echo "<button name='add-to-cart-button' class='hyperlink_button_inactive' type='submit' disabled>OUT OF STOCK <div class='dots-5' style='display: none;'></div> </button>";
                }
            echo "</form>";
            echo "<div class='form-result'></div>";
        echo "</div>";
    echo "</div>";
    echo "</div>";
    $conn->close();
?>