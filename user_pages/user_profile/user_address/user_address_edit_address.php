<?php
require_once "../../../init.php";
if (!is_user_logged_in()) {
    header("Location: ../../../user_pages/user_login/user_login.php");
    exit;
}

if (!isset($_GET['addressId'])) {
    header("Location: ../../../page_error.php");
    exit;
}
$addressId = $_GET['addressId'];
$addressData = null;

$addressQuery = $conn->prepare("SELECT * FROM user_address WHERE id = ? AND user_id = ?");
$addressQuery->bind_param("ii", $addressId, $_SESSION['user_id']);
$addressQuery->execute();
$result = $addressQuery->get_result();

if ($result->num_rows == 0) {
    header("Location: ../../../page_error.php");
    exit;
}
$addressData = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Edit User Address | Stuffed Pals</title>
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

<body id="user-address-edit-page">
    <?php include "../../../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1>Edit User Address</h1>
        </div>
    </header>
    <main class="white-background">
    <section class="form-section white-background">
            <form method="post" action="../../../user_pages/user_profile/user_address/user_address_edit_sender.php" id="user-address-form">
                <h2> Address </h2>
                <label for="firstname-field" class="form-field">
                    <h3> First name </h3>
                    <input type="text" id="firstname-field" name="user_firstname" required placeholder="First Name"
                        maxlength="100" autocomplete="given-name" 
                        value="<?php echo htmlspecialchars($addressData['user_firstname']); ?>">
                </label>
                <label for="lastname-field" class="form-field">
                    <h3> Last name </h3>
                    <input type="text" id="lastname-field" name="user_lastname" required placeholder="Last Name"
                        maxlength="100" autocomplete="family-name"
                        value="<?php echo htmlspecialchars($addressData['user_lastname']); ?>">
                </label>
                <label for="email-field" class="form-field">
                    <h3> Email </h3>
                    <input type="email" id="email-field" name="user_email" placeholder="Email"
                        maxlength="255" autocomplete="email"
                        value="<?php echo htmlspecialchars($addressData['user_email']); ?>">
                </label>
                <label for="phone-field" class="form-field">
                    <h3> Phone number </h3>
                    <input type="tel" id="phone-field" name="user_phone" required placeholder="Phone"
                        maxlength="15" autocomplete="tel" pattern="[+\-0-9]+"
                        title="Phone number can only contain digits, plus, and minus signs."
                        value="<?php echo htmlspecialchars($addressData['user_phone']); ?>">
                </label>
                <label for="address-field" class="form-field">
                    <h3> Street and Home address </h3>
                    <input type="text" id="address-field" name="user_homeaddress" required placeholder="Home Address"
                        maxlength="100" autocomplete="address-line1"
                        value="<?php echo htmlspecialchars($addressData['user_homeaddress']); ?>">
                </label>
                <label for="city-field" class="form-field">
                    <h3> City </h3>
                    <input type="text" id="city-field" name="user_city" required placeholder="City"
                        maxlength="100" autocomplete="address-level2"
                        value="<?php echo htmlspecialchars($addressData['user_city']); ?>">
                </label>
                <label for="postalcode-field" class="form-field">
                    <h3> Postal code </h3>
                    <input type="text" id="postalcode-field" name="user_postalcode" required placeholder="Postal Code"
                        maxlength="6" autocomplete="postal-code"
                        value="<?php echo htmlspecialchars($addressData['user_postalcode']); ?>">
                </label>
                <label for="state-field" class="form-field">
                    <h3> State </h3>
                    <input type="text" id="state-field" name="user_state" required placeholder="State"
                        maxlength="100" autocomplete="address-level1"
                        value="<?php echo htmlspecialchars($addressData['user_state']); ?>">
                </label>
                <label for="country-field" class="form-field">
                    <h3> Country </h3>
                    <select id="country-field" name="user_country" required autocomplete="country-name">
                        <option value="">Select country</option>
                        <option value="Poland" <?php echo ($addressData['user_country'] == 'Poland') ? 'selected' : ''; ?>>Poland</option>
                        <option value="Canada" <?php echo ($addressData['user_country'] == 'Canada') ? 'selected' : ''; ?>>Canada</option>
                        <option value="United Kingdom" <?php echo ($addressData['user_country'] == 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
                        <option value="Australia" <?php echo ($addressData['user_country'] == 'Australia') ? "selected" : ''; ?>>Australia</option>
                        <option value="United States" <?php echo ($addressData['user_country'] == 'United States') ? 'selected' : ''; ?>>United States</option>
                    </select>
                </label>
                <?php echo "<input type='hidden' name='address_id' value='". htmlspecialchars($addressId) ."'>"; ?>
                <div class="form-extra-information">
                    <a class="hyperlink_text" href="../../../user_pages/user_profile/user_profile.php">Cancel</a>
                </div>
                <button class="hyperlink_button" type="submit" name="edit-address-button">
                    <div class="button-text">EDIT ADDRESS</div>
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result" style="height: 20px"></div>
            </form>
        </section>
    </main>
    <?php include "../../../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("user-address-form", "edit-address-button", "../../../user_pages/user_profile/user_address/user_address_edit_sender.php", "edit-address");
        });
    </script> 
</body>
</html>