<?php
require_once "../../../init.php";
if (!is_user_logged_in()) {
    header("Location: ../../../user_pages/user_login/user_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Add new user address | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="../../../assets/logo_icon.png" type="../../../assets/logo_icon.png">
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

<body id="user-address-page">
    <?php include "../../../site_static_parts/navbar.php"; ?>
    <main class="white-background">
        <section class="form-section white-background">
            <form id="user-address-form" action="../../../user_pages/user_profile/user_address/user_address_add_sender.php" method="post">
                <h2>Add new address</h2>
                <label for="firstname-field" class="form-field">
                    <h3>First name<span class="alert">*</span></h3>
                    <input type="text" id="firstname-field" name="user_firstname" required placeholder="First name"
                        maxlength="100" autocomplete="given-name">
                </label>
                <label for="lastname-field" class="form-field">
                    <h3>Last name<span class="alert">*</span></h3>
                    <input type="text" id="lastname-field" name="user_lastname" required placeholder="Last name"
                        maxlength="100" autocomplete="family-name">
                </label>
                <label for="email-field" class="form-field">
                    <h3>Email address<span class="alert">*</span></h3>
                    <input type="email" id="email-field" name="user_email" required placeholder="Email address"
                        maxlength="255" autocomplete="email">
                </label>
                <label for="phone-field" class="form-field">
                    <h3>Phone number<span class="alert">*</span></h3>
                    <input type="tel" id="phone-field" name="user_phone" required placeholder="Phone number"
                        maxlength="12" autocomplete="tel">
                </label>
                <label for="address-field" class="form-field">
                    <h3>Street and Home address<span class="alert">*</span></h3>
                    <input type="text" id="address-field" name="user_homeaddress" required placeholder="Home address"
                        maxlength="100" autocomplete="address-line1">
                </label>
                <label for="city-field" class="form-field">
                    <h3>City<span class="alert">*</span></h3>
                    <input type="text" id="city-field" name="user_city" required placeholder="City"
                        maxlength="100" autocomplete="address-level2">
                </label>
                <label for="postalcode-field" class="form-field">
                    <h3>Postal code<span class="alert">*</span></h3>
                    <input type="text" id="postalcode-field" name="user_postalcode" required placeholder="Postal code"
                        maxlength="6" autocomplete="postal-code">
                </label>
                <label for="state-field" class="form-field">
                    <h3>State/voivodeship<span class="alert">*</span></h3>
                    <input type="text" id="state-field" name="user_state" required placeholder="State/voivodeship"
                        maxlength="100" autocomplete="address-level1">
                </label>
                <label for="country-field" class="form-field">
                    <h3>Country<span class="alert">*</span></h3>
                    <select id="country-field" name="user_country" required autocomplete="country-name">
                        <option value="">Select country</option>
                        <option value="Poland">Poland</option>
                        <option value="Germany">Germany</option>
                    </select>
                </label>
                <div class="form-extra-information">
                    <a class="hyperlink_text" href="../../../user_pages/user_profile/user_profile.php?content=address">&#11164 Cancel</a>
                </div>
                <button class="hyperlink_button" type="submit" name="add-address-buton">
                    <div class="button-text">Add address</div>
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result"></div>
            </form>
        </section>
    </main>
    <?php include "../../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("user-address-form", "add-address-button", "../../../user_pages/user_profile/user_address/user_address_add_sender.php", "add-address");
        });
    </script> 
</body>
</html>