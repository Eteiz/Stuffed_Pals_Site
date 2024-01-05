<?php
// Checking if user is logged in
require_once "../../init.php";
if (!is_user_logged_in()) {
    header("Location: ../../user_pages/user_login/user_login.php");
    exit;
}

// Choosing the subsite to load
$content = $_GET['content'] ?? 'details';
if (!in_array($content, ['details', 'orders', 'address'])) {
    header("Location: ../../page_error.php");
    exit;
}
$contentFile = "";
switch ($content) {
    case 'details':
        $contentFile = 'user_details/user_details_loader.php';
        break;
    case 'orders':
        $contentFile = 'user_orders/user_orders_loader.php';
        break;
    case 'address':
        $contentFile = 'user_address/user_address_loader.php';
        break;
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

    <link rel="stylesheet" href="../../../styles.css">
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
            <a href="user_profile.php?content=details" class="hyperlink_button">Account Details</a>
            <a href="user_profile.php?content=orders" class="hyperlink_button">Order History</a>
            <a href="user_profile.php?content=address" class="hyperlink_button">Shipping Address</a>
        </div>
        <div id="user-profile-option" class="section-content">
            <?php include "../../user_pages/user_profile/" . $contentFile; ?>
        </div>
    </main>
    <?php include "../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
            handleFormSubmit('user-delete-form', 'delete-button', '../../../user_pages/user_profile/user_details/userdelete_sender.php', 'delete');
            handleFormSubmit('user-logout-form', 'logout-button', '../../../user_pages/user_profile/user_details/userlogout_sender.php', 'logout');
        });
    </script> 
    <?php if($contentFile == 'user_address/user_address_loader.php') echo "<script src='../../../user_pages/user_profile/user_address/user_address_delete_updater.js'></script>"; ?>
</body>

</html>