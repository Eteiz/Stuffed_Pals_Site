<nav class="white_background">
		<div id="hyperlink-section">
			<a class="hyperlink_text" href="#Shop">Shop</a>
			<a class="hyperlink_text" href="about_us.php">About</a>
			<a class="hyperlink_text" href="customer_service.php">Help</a>
		</div>
		<div id="logo-section">
			<a class="hyperlink_logo" href="index.php">
				<img src="img\StuffedPals_Logo.png" alt = "Stuffed Pals logo"></img>
			</a>
		</div>
		<div id="user-section">
			<a class="hyperlink_icon" href="<?php echo isset($_SESSION['user_logged']) && $_SESSION['user_logged'] ? 'user_profile.php' : 'user_login.php'; ?>">
    			<img src="img/user_icon.png" alt="User icon">
			</a>
			<a class="hyperlink_icon" href="#Cart">
				<img src="img\cart_icon.png" alt = "Cart icon"></img>
			</a> 
		</div>
	</nav>