<?php require_once "../init.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About us | Stuffed Pals</title>
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

<body id="about-us-page">
    <?php include "../site_static_parts/navbar.php"; ?>
    <header class="image-background image-parallax">
        <div class="header-content white-background default-box-shadow">
            <h1> About Us </h1>
            <h3> 
                See the Thought Process Behind Creating Our Company <br>
                Discover our story, meet our team, and explore the love and dedication that goes into every plush pal we create.
            </h3>
        </div>
    </header>
    <main class="white-background">
        <div id="about-section" class="default-gradient-background section-rows">
            <div>
                <h1>Stuffed Pals is here to help you discover a new, cuddly friend 🧸</h1>
                <h2>Start your creative journey today and embrace the joy of a custom-made plush friend!</h2>
                <button class="hyperlink_button" onclick="window.location.href='../shop_page/shop.php'" title="/shop_page/shop.php"> Get started </button>
            </div>
            <img src="../assets/StuffedPals_AboutUs_3.png" alt="Three bears in different color" title="Three bears in different color"></img>
        </div>
        <div id="our-mission-section">
            <h3>Our Mission at Stuffed Pals</h3>
            <h1>Addressing Loneliness in Today's World</h1>
            <h4> 
                At Stuffed Pals, we recognize the increasing sense of loneliness in modern society, and we are here to make a difference. While our primary focus is on creating custom plush companions to bring joy and comfort, we also empower people to achieve independence.
            </h4>
        </div>
        <div id="values-section" class="section-columns">
            <div id="reverse-order" class="section-element section-rows white-background default-box-shadow round-corners">
                <span>
                    <h3>Our Team and Our Social Impact</h3>
                    <h2>Creating a Community for Impact</h2>
                    <span>
                        We at Stuffed Pals hold a firm belief that business can be a powerful force for good. 
                        That's why we've pledged to donate 1% of our equity, 1% of our profits, and 1% of our employees' time to projects that make a positive impact worldwide. 
                        Additionally, we take pride in being a socially responsible company, committed to using our business as a tool to address social and environmental issues, much like a certified B Corporation.
                    </span>
                </span>
                <img src="../assets/StuffedPals_AboutUs_1.png" alt="Photo of our team working in magazine" title="Photo of our team working in magazine"></img>
            </div>
            <div class="section-element section-rows white-background default-box-shadow round-corners">
                <span>
                    <h3>Our Commitment to Sustainability</h3>
                    <h2>Building a Business for the Future</h2>
                    <span>
                        In our quest to build a lasting legacy with Stuffed Pals, we are deeply invested in the sustainability of our planet. 
                        Our Sustainability Fund is focused on promoting environmentally responsible practices, not just within our company but also empowering our network of suppliers and partners to do the same. 
                        We are dedicated to ensuring that Stuffed Pals not only stands the test of time but also contributes positively to our planet and its future.
                    </span>  
                </span>
                <img src="../assets/StuffedPals_AboutUs_2.png" alt="Photo of our team in front of our shop" title="Photo of our team in front of our shop"></img>
            </div>
        </div>
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../js_scripts/form_updater.js"></script>
    <script>
        $(document).ready(function() {
        handleFormSubmit("newsletter-form", "subscribe-button", "../newsletter/newsletter_sender.php", "newsletter");
        });
    </script>   
</body>

</html>