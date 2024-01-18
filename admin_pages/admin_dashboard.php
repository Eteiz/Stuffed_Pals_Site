<?php 
session_start();
if (!isset($_SESSION["admin_logged"]) || $_SESSION["admin_logged"] !== true) {
    header("Location: ../index.php");
    exit;
}


$content = $_GET['content'] ?? 'products';
if (!in_array($content, ['products', 'orders', 'users'])) {
    header("Location: ../../page_error.php");
    exit;
}
$contentFile = "";
switch ($content) {
    case 'products':
        $contentFile = 'admin_products/admin_products_loader.php';
        break;
    case 'orders':
        $contentFile = 'admin_orders/admin_orders_loader.php';
        break;
    case 'users':
        $contentFile = 'admin_users/admin_users_loader.php';
        break;
}
?>
<head>
    <meta charset="UTF-8">

    <title>Admin dashboard | Stuffed Pals</title>
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
<body id="admin-dashboard-page">
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> Dashboard </h1>
            <h3> Welcome to admin dashboard where you can manage your website. </h3>
            <form id='admin-logout-form' action='../admin_pages/adminlogout_sender.php' method='post'>
                <button class='hyperlink_button_reverse' type='submit' name='logout-button' title='Log out'>
                    <div class='button-text'>Log out</div>
                    <div class='dots-5' style='display: none;'></div>
                </button>
            <div class='form-result'></div>
        </form>
        </div>
    </header>
    <main class="white-background">
        <div class="section-rows">
            <button onclick="location.href='admin_dashboard.php?content=products'" class="hyperlink_button" title="admin_pages/admin_dashboard.php?content=products">Products</button>
            <button onclick="location.href='admin_dashboard.php?content=orders'" class="hyperlink_button" title="admin_pages/admin_dashboard.php?content=orders">Orders</button>
            <button onclick="location.href='admin_dashboard.php?content=users'" class="hyperlink_button" title="admin_pages/admin_dashboard.php?content=users">Users</button>
        </div>
        <div id="dashboard-option" class="section-content">
            <?php include "../admin_pages/" . $contentFile; ?>
        </div>
        <?php include "../site_static_parts/footer.php"; ?>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src='../../js_scripts/form_updater.js'></script>
    <script>
        $(document).ready(function() { handleFormSubmit('admin-logout-form', 'logout-button', '../../admin_pages/adminlogout_sender.php', 'admin-logout'); });
    </script>
    <?php 
        if($contentFile == 'admin_products/admin_products_loader.php') { 
            echo "<script src='../../admin_pages/admin_products/admin_products_delete_updater.js'></script>"; 
            echo "<script>";
                echo "$(document).ready(function() { handleFormSubmit('admin-product-form', 'edit-button', '../../admin_pages/admin_products/admin_products_edit_sender.php', 'edit-product'); });";
            echo "</script>";
        }
        else if($contentFile == 'admin_orders/admin_orders_loader.php') { 
            echo "<script>";
                echo "$(document).ready(function() { handleFormSubmit('admin-order-form', 'edit-button', '../../admin_pages/admin_orders/admin_orders_edit_sender.php', 'edit-order'); });";
            echo "</script>";
        }
        else if($contentFile == 'admin_users/admin_users_loader.php') { 
            echo "<script src='../../admin_pages/admin_users/admin_users_delete_updater.js'></script>"; 
        }
    ?>
</body>
</html>
