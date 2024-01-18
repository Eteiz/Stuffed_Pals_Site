<?php
require_once "../init.php";

$userId = $_SESSION['user_id'];
startCartReservation($userId);

if(isCartEmpty($_SESSION["user_id"])) {
    header("Location: ../cart_page/cart.php");
    exit;
}

// Loading user's addresses from database
$addressQuery = $conn->prepare("SELECT * FROM user_address WHERE user_id = ?");
$addressQuery->bind_param("i", $userId);
$addressQuery->execute();
$addressResult = $addressQuery->get_result();
$addresses = [];
while ($row = $addressResult->fetch_assoc()) {
    $addresses[] = $row;
}


// Loading cart's reservation time from database
$stmt = $conn->prepare("SELECT cart_reservation_time FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $reservationTime = strtotime($row['cart_reservation_time']);
    $currentTime = time();
    $elapsedTime = $currentTime - $reservationTime; 
    $totalReservationTime = 15 * 60;
    $remainingSeconds = $totalReservationTime - $elapsedTime; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords"
        content="Custom Plush Toys, Personalized Teddy Bears, Unique Plush Gifts, Design Your Own Stuffed Animal, Plush Animal Accessories, Special Occasion Plushies">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="../assets/logo_icon.png" type="../assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body id="checkout-page">
    <main class="white-background">
        <section class="form-section white-background">
            <form method="post" action="../checkout_page/checkout_form_sender.php" id="user-order-form">
                <h1> Checkout details </h1>
                <!-- Reservation timer display -->
                <h3>The products in this order are currently reserved for you for the next: <span class="highlighted" id="timer"></span> minutes.</h3>
                <script>
                    function startTimer(duration, display) {
                        var timer = duration, minutes, seconds;
                        var end = setInterval(function () {
                            if (timer >= 0) {
                                minutes = parseInt(timer / 60, 10);
                                seconds = parseInt(timer % 60, 10);

                                minutes = minutes < 10 ? "0" + minutes : minutes;
                                seconds = seconds < 10 ? "0" + seconds : seconds;

                                display.textContent = minutes + ":" + seconds;
                                timer--;
                            } else {
                                clearInterval(end);
                                display.textContent = "00:00";
                            }
                        }, 1000);
                    }
                    window.onload = function() {
                        var remainingSeconds = <?php echo max(0, $remainingSeconds); ?>;
                        var display = document.querySelector('#timer');
                        startTimer(remainingSeconds, display);
                    };
                </script>
                <!-- Shipping address details -->
                <h2> Shipping address </h2>
                <label for="user-address-select" class="form-field">
                    <select id="user-address-select" name="selected_address">
                        <option value="">Select existing user address</option>
                        <?php foreach ($addresses as $address): ?>
                        <option value="<?php echo $address['id']; ?>">
                            <?php echo htmlspecialchars($address['user_firstname'] . ' ' . $address['user_lastname'] . ', ' . $address['user_homeaddress'] . ', ' . $address['user_postalcode'] . ' ' . $address['user_city']); ?>
                        </option>
                        <?php endforeach; ?>
                        <?php if (empty($addresses)): ?>
                        <option value="">---</option>
                        <?php endif; ?>
                    </select>
                </label>
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
                    <h3>Email<span class="alert">*</span></h3>
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
                    <input type="text" id="state-field" name="user_state" required placeholder="State/voivodeship" maxlength="100"
                        autocomplete="address-level1">
                </label>
                <label for="country-field" class="form-field">
                    <h3>Country<span class="alert">*</span></h3>
                    <select id="country-field" name="user_country" required autocomplete="country-name">
                        <option value="">Select country</option>
                        <option value="Poland">Poland</option>
                        <option value="Germany">Germany</option>
                    </select>
                </label>
                <label for="remember-address">
                    <input type="checkbox" id="remember-address" name="remember_address">
                    <strong>I want to remember this address (add it to user's addresses)</strong>
                </label>

                <!-- Delivery method -->
                <label for="delivery-field" class="form-field">
                    <h2>Delivery</h2>
                    <h3>Delivery method<span class="alert">*</span></h3>
                    <select id="delivery-field" name="delivery_method" rquired>
                        <option value="">Select delivery method</option>
                        <option value="Standard">Standard delivery ($10.00)</option>
                    </select>
                </label>
                <!-- Payment method -->
                <label for="payment-field" class="form-field">
                    <h2>Payment</h2>
                    <h3>Payment method<span class="alert">*</span></h3>
                    <select id="payment-field" name="payment_method" required>
                        <option value="">Select payment method</option>
                        <option value="Card">Credit card</option>
                        <option value="On-delivery">Cash on delivery</option>
                    </select>
                </label>

                <!-- Order summary --> 
                <div class="form-extra-information">
                    <a class="hyperlink_text" href="../cart_page/cart.php" title="/cart_page/cart.php"><h3>&#11164 Back to cart</h3></a>
                </div>
                <button class="hyperlink_button" type="submit" name="finalize-order-buton" title="Finish transaction">
                    <div class="button-text">Finish transactcion</div>
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result"></div>
            </form>
        </section>
        <!-- Checkout details -->
        <?php include "../checkout_page/checkout_details_loader.php"; ?>
    </main>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../checkout_page/checkout_form_updater.js"></script>
    <script src="../checkout_page/checkout_timer_updater.js"></script>
    <script src="../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("user-order-form", "finalize-order-buton", "../checkout_page/checkout_form_sender.php", "create-order");
        });
    </script>  
</body>

</html>