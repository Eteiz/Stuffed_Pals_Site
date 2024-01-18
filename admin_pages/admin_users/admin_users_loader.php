<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stuffedpals_database";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<div id='admin-user-section'>";
    echo "<div class='section-header'>";
        echo "<h1>User details</h1>";
        echo "<div class='section-information section-rows'>";
            echo "<h3 class='user-id'>Id</h3>";
            echo "<h3 class='user-login'>Username</h3>";
            echo "<h3 class='user-email'>User email</h3>";
            echo "<h3 class='user-date'>Created</h3>";
            echo "<h3 class='user-delete'></h3>";
        echo "</div>";
    echo "</div>";
    echo "<hr class='outer'>";
    echo "<div class='section-content'>";

$query = "SELECT id, user_login, user_email, date_created FROM user";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<form id='admin-user-form' action='../../admin_pages/admin_users/admin_users_delete_sender.php' class='section-element section-columns white-background default-box-shadow' method='post'>";
            echo "<div class='section-rows'>";
                    echo "<h4 class='user-id'>". htmlspecialchars($row['id']) ."</h4>";
                    echo "<h4 class='user-login'>". htmlspecialchars($row['user_login']) ."</h4>";
                    echo "<h4 class='user-email'>". htmlspecialchars($row['user_email']) ."</h4>";
                    echo "<h4 class='user-date'>". htmlspecialchars($row['date_created']) ."</h4>";
                    echo "<button type='button' class='user-delete hyperlink_button_reverse' title='Remove user' user-id='" . $row['id'] . "'>X</button>"; 
                echo "</div>";
            echo "<div class='form-result' user-id='" . $row['id'] . "'></div>";
        echo "</form>";
    }
} else {
    echo "<h2>No users found.</h2>";
}
echo "</div>";
echo "</div>";

$conn->close();
?>



