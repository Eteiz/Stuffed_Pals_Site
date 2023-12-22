<?php
require_once "../../../init.php";

$userId = $_SESSION["user_id"];

$userQuery = $conn->prepare("SELECT user_login, user_email, date_created FROM User WHERE id = ?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userRow = $userResult->fetch_assoc()) {
    echo "<div id='user-profile-account-details' class='section-title'>";
        echo "<h1 style='margin-bottom: 20px;'>Account Details</h1>";
        echo "<form action='../../user_pages/user_profile/userlogout_sender.php' method='post' id='user-logout-form'>";
            echo "<button class='hyperlink_button' type='submit' name='logout-button'>Log Out</button>";
        echo "</form>";
        echo "<hr style='height: 2px;'>";
        echo "<div class='section-row'>";
            echo "<h3>Username</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["user_login"]) ."</h4>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='section-row'>";
            echo "<h3>Email address</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["user_email"]) ."</h4>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='section-row'>";
            echo "<h3>Created</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["date_created"]) ."</h4>";
        echo "</div>";
        echo "<hr style='height: 2px'>";
        echo "<div class='form-section white-background'>";
            echo"<form action='../../user_pages/user_profile/userdelete_sender.php' method='post' id='user-delete-form'>";
                echo "<button class='hyperlink_button' type='submit' name='delete-button'>Delete Account</button>";
                echo "<label>";
                    echo "<input type='checkbox' name='confirm-delete' required>";
                    echo "I am aware that deleting my account is an irreversible action.";
                echo "</label>";
                echo "<div class='form-result' style='height: 20px'></div>";
            echo "</form>";
        echo "</div>";
    echo "</div>";
} else {
    echo "User not found.";
}
$conn->close();
?>
