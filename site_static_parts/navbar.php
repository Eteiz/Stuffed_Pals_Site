<nav class="white_background">
    <div id="links-section" class="section-content-col">
        <a class="hyperlink_text" href="../../shop_page/shop.php">Shop</a>
        <a class="hyperlink_text" href="../../about_us_page/about_us.php">About</a>
        <a class="hyperlink_text" href="../../customer_service_page/customer_service.php">Help</a>
    </div>
    <div id="logo-section" class="section-content-col">
        <a href="../../index.php">
            <img class="hyperlink_icon" src="../../assets/StuffedPals_Logo.png" alt="Stuffed Pals logo"></img>
        </a>
    </div>
    <div id="user-section" class="section-content-col">
        <a class="hyperlink_icon"
            href="<?php echo isset($_SESSION['user_logged']) && $_SESSION['user_logged'] ? '../../user_pages/user_profile/user_profile.php' : '../../user_pages/user_login/user_login.php'; ?>">
            <img src="../../assets/icons/<?php echo isset($_SESSION['user_logged']) && $_SESSION['user_logged'] ? 'user_icon_logged.png' : 'user_icon.png'; ?>"
                alt="User icon">
        </a>
        <a class="hyperlink_icon" href="#Cart">
            <img src="../../assets/icons/cart_icon.png" alt="Cart icon"></img>
        </a>
    </div>
</nav>