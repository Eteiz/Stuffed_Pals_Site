<?php
require_once "../../init.php";
if (!is_user_logged_in()) {
    header("Location: ../../user_pages/user_login/user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Your profile | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="../../assets/logo_icon.png" type="../../assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="../../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="user-page">
    <?php include "../../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1>Hello <?php echo htmlspecialchars($_SESSION["user_login"], ENT_QUOTES, "UTF-8"); ?></h1>
            <h3>
                Welcome to your personalized dashboard, where your preferences shape your experience.
            </h3>
        </div>
    </header>
    <main class="white-background">
        <div class="section-header">
            <button class="hyperlink_button" data-option="user_details">Account Details</button>
            <button class="hyperlink_button" data-option="user_orders">Order History</button>
            <button class="hyperlink_button" data-option="user_address">Shipping Address</button>
        </div>
        <div id="user-profile-option" class="section-content">
            <!-- Script responsible for loading the clicked option -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var buttons = document.querySelectorAll('.section-header .hyperlink_button');

                    buttons.forEach(function(button) {
                        button.addEventListener("click", function() {
                            var option = this.getAttribute('data-option');
                            loadContent(option);
                        });
                    });

                    function loadContent(option) {
                        // Unfocusing all buttons and focusing the active one
                        buttons.forEach(btn => btn.classList.remove('focused'));
                        var activeButton = document.querySelector('.section-header .hyperlink_button[data-option="' + option + '"]');
                        if (activeButton) {
                            activeButton.classList.add('focused');
                        }

                        var contentDiv = document.getElementById('user-profile-option');
                        fetch("../../user_pages/user_profile/" + option + "/" + option + "_loader.php")
                            .then(response => response.text())
                            .then(data => {
                                contentDiv.innerHTML = data;
                            })
                            .catch(error => console.error("Error:", error));
                    }
                    loadContent('user_address');
                });
            </script>
        </div>
    </main>
    <?php include "../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("user-delete-form", "delete-button", "../../user_pages/user_profile/userdelete_sender.php", "delete");
        handleFormSubmit("user-logout-form", "logout-button", "../../user_pages/user_profile/userlogout_sender.php", "logout");
        });
    </script>  
    <script src="../../../user_pages/user_profile/user_address/user_address_delete_updater.js"></script>
</body>

</html>