<?php
require_once __DIR__ . '/../../../init.php';

$userId = $_SESSION['user_id'];

$addressQuery = $conn->prepare("SELECT * FROM user_address WHERE user_id = ?");
$addressQuery->bind_param("i", $userId);
$addressQuery->execute();
$addressResult = $addressQuery->get_result();

if ($addressResult->num_rows > 0) {
    echo "<div id='user-profile-address'>";
    echo "<h1>Shipping Address</h1>";
    echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_add_address.php\"' title='Add new address'>Add New Address</button>";
    echo "<hr class='outer'>";

    while ($addressRow = $addressResult->fetch_assoc()) {
        echo "<form class='section-element section-columns hover-box-shadow'>";
            echo "<div class='details-section section-rows'>";
                echo "<div>";
                    echo "<h3 class='highlighted'>". htmlspecialchars($addressRow["user_firstname"]) ." ". htmlspecialchars($addressRow["user_lastname"]) ."</h3>";
                    echo "<h4>". htmlspecialchars($addressRow["user_email"]) ."</h4>";
                    echo "<h4>". htmlspecialchars($addressRow["user_phone"]) ."</h4>";
                echo "</div>";
                echo "<div>";
                    echo "<h3 class='highlighted'>". htmlspecialchars($addressRow["user_homeaddress"]) ."</h3>";
                    echo "<h4>". htmlspecialchars($addressRow["user_city"]) .", ". htmlspecialchars($addressRow["user_postalcode"]) ."</h4>";
                    echo "<h4>". htmlspecialchars($addressRow["user_state"]) .", ". htmlspecialchars($addressRow["user_country"]) ."</h4>";
                echo "</div>";
            echo "</div>";
            echo "<div class='buttons-section section-columns'>";
                echo "<div class='section-rows'>";
                    echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_edit_address.php?addressId=" . htmlspecialchars($addressRow["id"]) . "\"' title='Edit address'>Edit</button>";
                    echo "<button type='button' class='delete-address-button hyperlink_button_reverse' user-address-id='" . htmlspecialchars($addressRow["id"]) . "' title='Delete address'>Delete</button>";
                echo "</div>";  
                echo "<div class='form-result' user-address-id='" . htmlspecialchars($addressRow["id"]) . "'></div>";
            echo "</div>";
        echo "</form>";
    }  
    echo "</div>";      
} else {
    echo "<div id='user-profile-address-empty' class='section-columns'>";
        echo "<img src='../../../assets/icons/map_big_icon.png' alt='Map marker icon' title='Map marker icon'></img>";
        echo "<h1>No addresses found!</h1>";
        echo "<h4>";
                echo "It seems like you haven't added any shipping addresses yet. 
                But worry not! It's the perfect moment to create your first one.
                Click on the button below to start and get ready to receive all the goodies you desire!";
        echo "</h4>";
        echo "<button type='button' class='hyperlink_button' onClick='location.href=\"../../../user_pages/user_profile/user_address/user_address_add_address.php\"' title='/user_pages/user_profile/user_address/user_address_add_address.php'>Add New Address</button>";
    echo "</div>";
}
$conn->close();
?>