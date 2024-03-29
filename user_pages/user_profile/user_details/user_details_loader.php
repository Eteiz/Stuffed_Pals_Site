<?php
require_once "../../init.php";

$userId = $_SESSION["user_id"];

$userQuery = $conn->prepare("SELECT user_login, user_email, date_created FROM User WHERE id = ?");
$userQuery->bind_param("i", $userId);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userRow = $userResult->fetch_assoc()) {
    echo "<div id='user-profile-details' class='section-title'>";
        echo "<h1>Account details</h1>";
        echo "<form id='user-logout-form' action='../../../user_pages/user_profile/user_details/userlogout_sender.php' method='post'>";
            echo "<button class='hyperlink_button' type='submit' name='logout-button' title='Log out'>
                <div class='button-text'>Log out</div>
                <div class='dots-5' style='display: none;'></div>
            </button>";
            echo "<div class='form-result'></div>";
        echo "</form>";
        echo "<hr class='outer'>";
        echo "<div class='section-element'>";
            echo "<h3>Username</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["user_login"]) ."</h4>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='section-element'>";
            echo "<h3>Email address</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["user_email"]) ."</h4>";
        echo "</div>";
        echo "<hr>";
        echo "<div class='section-element'>";
            echo "<h3>Created</h3>";
            echo "<h4 style='color: var(--primary-color)'>". htmlspecialchars($userRow["date_created"]) ."</h4>";
        echo "</div>";
        echo "<hr class='outer'>";
        echo "<div class='form-section'>";
            echo"<form id='user-delete-form' action='../../../user_pages/user_profile/user_details/userdelete_sender.php' method='post'>";
                echo "<button class='hyperlink_button_reverse' type='submit' name='delete-button' title='Delete account'>
                        <div class='button-text'>Delete account</div>
                        <div class='dots-5' style='display: none;'></div>
                    </button>";
                echo "<label>";
                    echo "<input type='checkbox' name='confirm-delete' required>";
                    echo "I am aware that deleting my account is an irreversible action.";
                echo "</label>";
                echo "<div class='form-result'></div>";
            echo "</form>";
        echo "</div>";
    echo "</div>";
} else {
    echo "User not found.";
}
$conn->close();
?>
