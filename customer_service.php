<?php
session_start();
if (!isset($_SESSION['user_logged']) && !isset($_SESSION['user_id']) && !isset($_SESSION['user_login'])) {
    $_SESSION['user_logged'] = false;

	$_SESSION['user_id'] = NULL;
    $_SESSION['user_login'] = NULL;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <title>Customer service | Stuffed Pals</title>
    <meta name="description" content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords" content="plushies, stuffed animals, stuffed">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="img\logo_icon.png" type="img\logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-control" content="no-cache">

	<link rel="stylesheet" href="styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
	<?php include 'site_static_parts\navbar.php'; ?>
    <header>
        <div class="header-content white_background">
            <h1> Customer Service </h1>
            <h3> Your satisfaction is our priority—reach out to us with any questions or for support, 
                and we'll ensure you find all the answers and assistance you need. 
            </h3>
        </div>
    </header>
    <main>
        <section id="contact-section" class="default_gradient_background">
            <div class="section-container">
                <img src="img/plush_3.png" src="Scuttle Plush"></img>
                <div class="section-element white_background">
                    <div class="section-element-header">
                        <h1><u>Contact us</u></h1>
                        <span> We value your feedback, questions, and comments. 
                            Reach out to us through any of the following methods, and our dedicated team will respond as soon as possible.
                        </span>
                    </div>
                    <div class="section-element-content">
                        <div class="section-element-content-row">
                            <div class="section-element-content-row-header">
                                <img src="img/house_icon.png" alt="House icon"></img>
                                <h3> Visit us </h3>
                            </div>
                            <div class="section-element-content-row-content">
                                <h4> Lorem 12/34 00-000 Ipsum </h4>
                            </div>
                        </div>
                        <div class="section-element-content-row">
                            <div class="section-element-content-row-header">
                                <img src="img/phone_icon.png" alt="Phone icon"></img>
                                <h3> Call us </h3>
                            </div>
                            <div class="section-element-content-row-content">
                                <h4> +48 123 456 789 </h4>
                            </div>
                        </div>
                        <div class="section-element-content-row">
                            <div class="section-element-content-row-header">
                                <img src="img/mail_icon.png" alt="Mail icon"></img>
                                <h3> Mail us </h3>
                            </div>
                            <div class="section-element-content-row-content">
                                <h4> StuffedPals@gmail.com </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq-section" class="white_background">
            <div class="section-header">
                <h1> Frequently Asked Questions </img></h1>
            </div>
            <div class="section-content white_background">
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> What products does Stuffed Pals offer? </h3></div>
                    <div class="section-content-row-description">
                        Stuffed Pals offers a unique selection of customizable plushies. Our range includes plush bases, a variety of plushie clothes, and numerous accessories to personalize your plush pal.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> How do I customize a plushie? </h3></div>
                    <div class="section-content-row-description">
                        Customizing a plushie is simple and fun! First, select a plush base from our collection. 
                        Next, choose from our range of clothes and accessories to create a look that's uniquely yours. 
                        You can mix and match items to your heart's content.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> Are the materials used for the plushies safe? </h3></div>
                    <div class="section-content-row-description">
                        Absolutely! Safety is our top priority. 
                        All materials used in our plushies, clothes, and accessories are non-toxic and comply with international safety standards.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> Can I wash the plushies? </h3></div>
                    <div class="section-content-row-description">
                        Yes, our plushies are washable. We recommend hand washing with mild detergent and air drying to maintain their shape and color.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> What age group are these plushies suitable for? </h3></div>
                    <div class="section-content-row-description">
                        Our plushies are designed for all ages! They are particularly popular among children and collectors.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> How long does shipping take? </h3></div>
                    <div class="section-content-row-description">
                        Shipping times vary depending on your location. 
                        Typically, orders are processed within 1-2 business days, and delivery takes 3-5 business days.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> Do you offer international shipping? </h3></div>
                    <div class="section-content-row-description">
                        Yes, we ship worldwide! Shipping fees and times will vary based on the destination.
                    </div>
                </div>
                <hr>
                <div class="section-content-row">
                    <div class="section-content-row-header"><h3> What is your return policy? </h3></div>
                    <div class="section-content-row-description">
                        We accept returns within 30 days of purchase, provided the items are in their original condition. 
                        Customized items are subject to a separate return policy, detailed on our website.
                    </div>
                </div>
                <hr>
            </div>
        </section>

        <section class="form-section white_background">
            <div class="section-header">
                <h1> Or ask here... </h1>
                <span> 
                    Got a question? Need assistance? 
                    Or perhaps you have some feedback for us? Fill out the form below, and our team will get back to you as swiftly as a plushie's hug! 
                    We're here to ensure that your experience with us is as cozy and delightful as our stuffed pals. 
                </span>
            </div>
            <form method="post" action="/php_scripts/contactform_sender.php" id="contact-form">
                <h2> Contact form </h2>
                <label for="first-name" class="form-field"> 
                    <h3> First name </h3>
                    <input type="text" name="first-name" id="first-name" required placeholder="First name" maxlength="100" autocomplete="given-name">
                </label>
                <label for="last-name" class="form-field">
                    <h3> Last name </h3>
                    <input type="text" name="last-name" id="last-name" required placeholder="Last name" maxlength="100" autocomplete="family-name">
                </label>
                <label for="email-address" class="form-field">
                    <h3> Email address </h3>
                    <input type="email" name="email" id="email-address" required placeholder="Email address" maxlength="100" autocomplete="email">
                </label>
                <label for="message" class="form-field">
                    <h3> Message content </h3>
                    <textarea name="message" id="message" required placeholder="Your message" maxlength="1000"></textarea>
                </label>
                <button class="hyperlink_button" type="submit" name="send-message-button">SEND MESSAGE</button>
                <div class="form-result">
                    <h4 id="contact-form-status" class="form-status"></h4>
                </div>
            </form>
        </section>
		<?php include 'site_static_parts\newsletter_form.php'; ?>
	</main>
	<?php include 'site_static_parts\footer.php'; ?>

    <script src="js_scripts\faq_accordion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js_scripts/newsletter_updater.js"></script>
    <script src="js_scripts/contactform_updater.js"></script>
</body>
</html>