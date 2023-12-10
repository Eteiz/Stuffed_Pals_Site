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
    $mainSliderWidth = 550 * $numImages;
    $iconSliderWidth = 110 * $numImages;

    // Product images
    echo "<div class='section-image-display'>";
    if ($numImages > 0) {
        echo "<div class='main-image-displayer'><div class='main-image-slider' style='width: {$mainSliderWidth}px;'>";
        foreach ($images as $imageRow) {
            echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "'>";
        }
        echo "</div></div>";

        echo "<div class='icon-image-displayer'><div class='icon-image-slider' style='width: {$iconSliderWidth}px;'>";
        foreach ($images as $imageRow) {
            echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "'>";
        }
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
            echo "<h2>" . htmlspecialchars($info["product_price"]) . " PLN </h2>";
        echo "</div>";
        echo "<div class='section-content-action-buttons'>";
            echo "<div class='quantity-button'>";
                if($notEmptyInventory) {
                    echo "<button id='decrease-quantity-button' class='hyperlink_button_reverse' type='submit'>-</button>";
                    echo "<input type='number' id='product-quantity' class='transparent_background' value='1' min='1' max='" . htmlspecialchars($info["quantity"]) . "' readonly>";
                    echo "<button id='increase-quantity-button' class='hyperlink_button_reverse' type='submit'>+</button>";
                    echo "</div>";
                    echo "<button class='hyperlink_button' type='sumbit'>ADD TO CART</button>";
                } else {
                    echo "<button id='decrease-quantity-button' class='hyperlink_button_reverse_inactive' disabled>-</button>";
                    echo "<input type='number' id='product-quantity' class='transparent_background' value='0' min='0' max='0' readonly style='border-color: var(--action-color-disabled);'>";
                    echo "<button id='increase-quantity-button' class='hyperlink_button_reverse_inactive' disabled>+</button>";
                    echo "</div>";
                    echo "<button class='hyperlink_button_inactive' type='sumbit' disabled>OUT OF STOCK</button>";
                }
            echo "</div>";
        echo "</div>";
    echo "</div>";
    echo "</div>";
    $conn->close();
?>