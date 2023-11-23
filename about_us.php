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

    <title>About us | Stuffed Pals</title>
    <meta name="description"
        content="Stuffed Pals is a one-of-a-kind company that specializes in providing a unique and creative experience for plushie enthusiasts of all ages. We pride ourselves on offering a wide range of parts and accessories that enable our customers to create their own customizable plush toys.">
    <meta name="keywords" content="plushies, stuffed animals, stuffed">
    <meta name="author" content="Marta Ambroziak">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bots can index and follow links on site -->
    <meta name="robots" content="index, follow">
    <link rel="icon" href="assets/logo_icon.png" type="assets/logo_icon.png">
    <meta name="theme-color" content="#A066E9">
    <!-- Support for older IE versions -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>

<body id="about-us-page">
    <?php include 'site_static_parts\navbar.php'; ?>
    <header>
        <div class="header-content white_background">
            <h1> About Us </h1>
            <h3> Discover the thought process behind creating our company! </h3>
        </div>
    </header>
    <main>
        <section id="who-we-are-section" class="white_background">
            <div class="section-header">
                <h1><img src="assets/StuffedPals_Logo.png" alt="Stuffed Pals Logo"></img></h1>
                <h3> Welcome to the cozy corner of Stuffed Pals - your go-to haven for plushies that are more than just
                    toys; they're treasured friends.
                    Born from a tapestry of dreams and a vibrant imagination, our family-run business celebrates the
                    simple joys of life through every stitch and fabric chosen in our creations.
                </h3>
            </div>
            <div class="section-content">
                <div class="section-content-container">
                    <img src="assets/aboutus_1.png" alt="Hedgehog plushie in woods"></img>
                    <div class="section-content-container-description">
                        <h2> Who are we? </h2>
                        <p>
                            At Stuffed Pals, we are a collective of artisans, dreamers, and enthusiasts who share a
                            common vision: to bring joy and companionship to people everywhere through our lovingly
                            handcrafted plush companions.
                            Our journey began as a small workshop, where the hum of sewing machines and laughter mingled
                            in the air, giving life to fabric and filling.
                            Today, we've grown into a close-knit family business that cherishes the bonds we form with
                            each customer and community we touch.
                        </p>
                        <p>
                            Our artisans are skilled storytellers whose narratives are sewn into the fabric of every
                            plushie.
                            We believe in the power of play, the warmth of hugs, and the silent comfort that a
                            well-loved plush companion can provide.
                            With each stitch and selection of materials, we embed a piece of our story, hoping it will
                            become a cherished part of yours.
                        </p>
                    </div>
                </div>
                <div class="section-content-container">
                    <div class="section-content-container-description">
                        <h2> Why are we doing this?</h2>
                        <p>
                            We do what we do at Stuffed Pals for the sparkle of joy in a child's eyes, for the comfort
                            we can provide to a heart in need of solace, and for the shared moments of happiness that
                            our plushies can bring.
                            In a world that's increasingly digital, we stand as champions for the tangible, the real,
                            and the heartfelt.
                            We believe that in holding something real, there's an irreplaceable connection that is
                            formed.
                        </p>
                        <p>
                            Our mission transcends the mere act of creating toys. We are nurturing a space where
                            imagination is kindled, where individuality is celebrated, and where the simplicity of a
                            cuddle can mean everything.
                            We are committed to ethical practices, sustainability, and giving back to the community that
                            has embraced us.
                            For us, it's about creating a legacy - of love, laughter, and the kind of joy that is passed
                            down through generations.
                        </p>
                    </div>
                    <img src="assets/aboutus_2.png" alt="Worm plushie in roses"></img>
                </div>
            </div>

        </section>
        <section id="our-mission-section" class="default_gradient_background">
            <div class="section-header">
                <h1> Our Mission & Ethos </h1>
            </div>
            <div class="section-content">
                <div class="section-content-row white_background">
                    <h2> Our Philosophy </h2>
                    <span> At Stuffed Pals, we believe that comfort is personal.
                        Everyone deserves a companion tailored to their preferences, one that provides solace in moments
                        of solitude.
                        We're not just creating toys; we're crafting memories, connections, and a source of genuine
                        comfort.
                    </span>
                    <img src="assets/icons/book_icon.png" alt="Book Icon"></img>
                </div>
                <div class="section-content-row white_background">
                    <h2> Eco-friendly & Ethical </h2>
                    <span> Our planet and its inhabitants matter to us deeply.
                        This is why every plushie we craft is made from environmentally-friendly materials.
                        We stand firmly against exploitative labor practices and collaborate exclusively with producers
                        who value fair and living wages.
                        With each Stuffed Pal, you're not only gaining a companion but also supporting a cause that
                        emphasizes global responsibility.
                    </span>
                    <img src="assets/icons/eco_icon.png" alt="Eco Icon"></img>
                </div>
                <div class="section-content-row white_background">
                    <h2> Our Journey </h2>
                    <span>
                        In a world where screens often overshadow human touch and interactions, Stuffed Pals was
                        conceived as a beacon of warmth and connection.
                        We observed a rising tide of loneliness and sought a solution that was both tangible and
                        heartwarming.
                        Thus, the idea of customizable plush companions was born.
                    </span>
                    <img src="assets/icons/journey_icon.png" alt="Navigation Icon"></img>
                </div>
            </div>
        </section>

        <section id="our-team-section" class="white_background">
            <div class="section-header">
                <h1> Our team </h1>
                <h3>
                    At Stuffed Pals, we're more than just a company - we're a family.
                    Our team is composed of passionate individuals dedicated to creating comfort and joy for every
                    customer.
                    Here's a glimpse into the hearts and minds behind our plush companions:
                </h3>
            </div>
            <div class="section-containter">
                <div id="our-team-section-slider">
                    <div class="section-slider-element">
                        <img src="assets/team-photos/ourteam_1.jpg" alt="Half-lenght of Marta Ambroziak"></img>
                        <div class="ourteam_section_slider_element_description">
                            <h3> CEO & Founder </h3>
                            <h2> Marta Ambroziak </h2>
                            <span> Marta is the visionary and chief designer at Stuffed Pals.
                                Her passion for delivering joy to children worldwide drives the company's creative
                                spirit.
                                With a keen eye for design and a heart full of dreams, she has led Stuffed Pals from a
                                small workshop to an international brand.
                            </span>
                        </div>
                    </div>
                    <div class="section-slider-element">
                        <img src="assets/team-photos/ourteam_2.jpg" alt="Half-lenght of Marta Ambroziak"></img>
                        <div class="ourteam_section_slider_element_description">
                            <h3> CTO & Lead Programmer </h3>
                            <h2> Marta Ambroziak </h2>
                            <span> As the technological architect of Stuffed Pals, Marta ensures all digital aspects of
                                our operations run smoothly.
                                Her expertise in IT infrastructure and passion for innovation have been crucial in
                                building the robust online presence of Stuffed Pals.
                            </span>
                        </div>
                    </div>
                    <div class="section-slider-element">
                        <img src="assets/team-photos/ourteam_3.jpg" alt="Half-lenght of Marta Ambroziak"></img>
                        <div class="ourteam_section_slider_element_description">
                            <h3> Lead Designer </h3>
                            <h2> Marta Ambroziak </h2>
                            <span> Marta, the creative soul of our team, brings each plushie to life with her
                                extraordinary design skills.
                                She's the mastermind behind our signature customizable plushies, ensuring that every
                                piece is both adorable and unique.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-slider-buttons">
                <button class="slider-button slider-button-active"></button>
                <button class="slider-button"></button>
                <button class="slider-button"></button>
            </div>
        </section>
    </main>
    <?php include 'site_static_parts\newsletter_form.php'; ?>
    <?php include 'site_static_parts\footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js_scripts/newsletter_updater.js"></script>
    <script src="js_scripts/ourteam_slider.js"></script>
</body>
</html>