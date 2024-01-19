<?php          
    require_once "../config.php";

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

    // Product images
    echo "<div class='section-images section-columns'>";
    if ($numImages > 0) {
        echo "<div class='image-displayer'>";
            echo "<div class='image-displayer-slider section-rows' style='width: calc(100% * " . $numImages . ");'>";
                foreach ($images as $imageRow) {
                    echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "' title='" . htmlspecialchars($imageRow["image_description"]) . "' style='width: calc(100% / " . $numImages . ");'>";
                }
            echo "</div>";
        echo "</div>";
        echo "<div class='image-carousel section-rows'>";
            foreach ($images as $imageRow) {
                echo "<img src='../" . htmlspecialchars($imageRow["product_image_path"]) . "' alt='" . htmlspecialchars($imageRow["image_description"]) . "' title='" . htmlspecialchars($imageRow["image_description"]) . "'>";
            }
        echo "</div>";
    }
    else {
        echo "<div class='image-displayer'>";
            echo "<div class='image-displayer-slider section-rows' style='width: 100%;'>";
                echo "<img src='../assets/placeholder.png' alt='Placeholder image' title='Placeholder image' style='width: 100%;'>";
            echo "</div>";
        echo "</div>";
        echo "<div class='image-carousel section-rows'>";
            echo "<img src='../assets/placeholder.png' alt='Placeholder image' title='Placeholder image'>"; 
        echo "</div>";
    }
    echo "</div>";

    echo "<div class='section-content'>";
        echo "<div>";
            echo "<h3>". htmlspecialchars($info["supplier_name"]) ."</h3>";
            echo "<h1>" . htmlspecialchars($info["product_name"]) . "</h1>";
            echo "<h4>" . htmlspecialchars($info["product_description"]) . "</h4>";
            echo "<ul>";
                echo "<li>The materials used for crafting are safe for the environment</li>";
                echo "<li>Tailored to meet individual preferences</li>";
                echo "<li>Designed with meticulous attention to detail and to ensure durability</li>";
            echo "</ul>";
        echo "</div>";
        echo "<div class='section-action'>";
            echo "<h3> ★★★★☆ (3.98) </h3>";
            echo "<h2> $" . htmlspecialchars($info["product_price"]) ."</h2>";
            echo "<form class='add-to-cart-form section-rows' action='../cart_page/add_to_cart.php' method='post'>";
                echo "<div class='quantity-button section-rows'>";
                    $notEmptyInventory = $info["quantity"] > 0;
                    if($notEmptyInventory) {
                            echo "<button type='button' id='decrease-quantity-button' class='decrease-quantity-button hyperlink_button_reverse' title='Decrease quantity'>-</button>";
                            echo "<input type='number' id='product-quantity-button' name='quantity' class='product-quantity-button white-background' title='Product quantity' value='1' min='0' max='" . htmlspecialchars($info["quantity"]) . "'>";
                            echo "<button type='button' id='increase-quantity-button' class='increase-quantity-button hyperlink_button_reverse' title='Increase quantity'>+</button>";
                        echo "</div>";
                        echo "<input type='hidden' name='product_id' value='" . $productId . "'>";
                        echo "<button name='add-to-cart-button' class='hyperlink_button' type='submit' title='Add to cart'>Add to cart<div class='dots-5' style='display: none;'></div></button>";
                    } else {
                            echo "<button class='decrease-quantity-button hyperlink_button_reverse_inactive' title='Out of stock' disabled>-</button>";
                            echo "<input type='number' name='quantity' class='product-quantity-button white-background' title='Out of stock' value='0' min='0' max='0' readonly style='border-color: var(--action-color-disabled);'>";
                            echo "<button class='increase-quantity-button hyperlink_button_reverse_inactive' title='Out of stock' disabled>+</button>";
                        echo "</div>";
                        echo "<button name='add-to-cart-button' class='hyperlink_button_inactive' type='submit' title='Out of stock' disabled>Out of stock<div class='dots-5' style='display: none;'></div></button>";
                    }
            echo "</form>";
            echo "<div class='form-result'>";
        echo "</div>";
    echo "</div>";
    $conn->close();
?>