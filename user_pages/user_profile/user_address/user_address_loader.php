<?php
require_once __DIR__ . '/../../../init.php';

$userId = $_SESSION['user_id'];

$addressQuery = $conn->prepare("SELECT * FROM user_address WHERE user_id = ?");
$addressQuery->bind_param("i", $userId);
$addressQuery->execute();
$addressResult = $addressQuery->get_result();

if ($addressResult->num_rows > 0) {
    echo "<div id='user-profile-address'>";
    echo "<h1 style='margin-bottom: 20px;'>Shipping Address</h1>";
    echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_add_address.php\"'>Add New Address</button>";
    echo "<hr class='outer'>";

    while ($addressRow = $addressResult->fetch_assoc()) {
        echo "<form class='section-row hover-box-shadow'>";
            echo "<div class='section-row-content'>";
                echo "<div>";
                    echo "<h3 style='color: var(--primary-color)'>". htmlspecialchars($addressRow["user_firstname"]) ." ". htmlspecialchars($addressRow["user_lastname"]) ."</h3>";
                    echo "<h4>". htmlspecialchars($addressRow["user_email"]) ."</h4>";
                    echo "<h4>". htmlspecialchars($addressRow["user_phone"]) ."</h4>";
                echo "</div>";
                echo "<div>";
                    echo "<h3 style='color: var(--primary-color)'>". htmlspecialchars($addressRow["user_homeaddress"]) ."</h3>";
                    echo "<h4>". htmlspecialchars($addressRow["user_city"]) .", ". htmlspecialchars($addressRow["user_postalcode"]) ."</h4>";
                    echo "<h4>". htmlspecialchars($addressRow["user_state"]) .", ". htmlspecialchars($addressRow["user_country"]) ."</h4>";
                echo "</div>";
            echo "</div>";
            echo "<div>";
                echo "<div class='button-section'>";
                    echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_edit_address.php?addressId=" . htmlspecialchars($addressRow["id"]) . "\"'>Edit</button>";
                    echo "<button type='button' class='delete-address-button hyperlink_button_reverse' user-address-id='" . htmlspecialchars($addressRow["id"]) . "'>Delete</button>";
                echo "</div>";  
            echo "</div>";
            echo "<div class='form-result' user-address-id='" . htmlspecialchars($addressRow["id"]) . "'></div>";
        echo "</form>";
    }  
    echo "</div>";      
} else {
    echo "<div id='user-profile-address-empty'>";
        echo "<img src='../../../assets/icons/map_big_icon.png' alt='Map marker icon'></img>";
        echo "<h1>No addresses found!</h1>";
        echo "<h4>";
                echo "It seems like you haven't added any shipping addresses yet. 
                But worry not! It's the perfect moment to create your first one.
                Click on the button below to start and get ready to receive all the goodies you desire!";
        echo "</h4>";
        echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_add_address.php\"'>Add New Address</button>";
    echo "</div>";
}
$conn->close();
?>