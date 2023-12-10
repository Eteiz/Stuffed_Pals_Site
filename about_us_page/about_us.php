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
    <header class="image-background">
        <div class="header-content white_background default-box-shadow">
            <h1> About Us </h1>
            <h3> Discover the thought process behind creating our company! </h3>
        </div>
    </header>
    <main>
        <section id="who-we-are-section" class="white_background">
            <section class="section-description">
                <img src="../assets/StuffedPals_Name.png" alt="Stuffed Pals Name"></img>
                <h2>
                    The Stuffed Pals was founded on this simple premise—everybody needs a friend.
                </h2>
                <span>
                    <p>
                        We do what we do at Stuffed Pals for the sparkle of joy in a child's eyes,
                        for the comfort we can provide to a heart in need of solace, and for the shared moments of
                        happiness that our plushies can bring.
                        In a world that's increasingly digital, we stand as champions for the tangible, the real, and
                        the heartfelt.
                        We believe that in holding something real, there's an irreplaceable connection that is formed.
                    </p>
                    <p>
                        Our mission transcends the mere act of creating toys.
                        We are nurturing a space where imagination is kindled, where individuality is celebrated,
                        and where the simplicity of a cuddle can mean everything.
                        We are committed to ethical practices, sustainability, and giving back to the community that has
                        embraced us.
                        For us, it's about creating a legacy - of love, laughter, and the kind of joy that is passed
                        down through generations.
                    </p>
                </span>
            </section>
            <img src="../assets/About-us.png" alt="Collab of photos from our customers"></img>
        </section>
        <section id="our-ethos-section" class="default_gradient_background">
            <div class="section-card white_background hover-box-shadow">
                <h2>Comfort at all cost</h2>
                <span>
                    We believe that comfort is personal.
                    Everyone deserves a companion tailored to their preferences, one that provides solace in moments of
                    solitude.
                    We're not just creating toys; we're crafting memories, connections, and a source of genuine comfort.
                </span>
                <img src="../assets/icons/teddy-bear_icon.png" alt="Teddy Bear Icon"></img>
            </div>
            <div class="section-card white_background hover-box-shadow">
                <h2>Eco & Ethical</h2>
                <span>
                    Our planet and its inhabitants matter to us deeply.
                    We stand firmly against exploitative labor practices and collaborate exclusively with producers
                    who value fair and living wages.
                    With each Stuffed Pal, you're not only gaining a companion but also supporting a cause that
                    emphasizes global responsibility.
                </span>
                <img src="../assets/icons/eco_icon.png" alt="Eco Icon"></img>
            </div>
            <div class="section-card white_background hover-box-shadow">
                <h2>Quality & Art</h2>
                <span>
                    Every product at Stuffed Pals is a testament to our dedication to quality.
                    We meticulously craft each plushie and accessory with the utmost care and attention to detail,
                    ensuring they are not only durable but also have a unique charm.
                </span>
                <img src="../assets/icons/quality_icon.png" alt="Quality Icon"></img>
            </div>
        </section>
        <section id="our-team-section" class="white_background">
            <h1> Meet our Team! </h1>
            <h2> Meet the minds behind Stuffed Pals </h2>
            <div class="section-image-display">
                <div id="our-team-slider">
                    <div class="section-image-display-element">
                        <img src="../assets/team-photos/ourteam_1.jpg" alt="Marta Ambroziak's photo"></img>
                        <div class="section-image-display-element-description">
                            <h3> CEO & Manager </h3>
                            <h2> Marta Ambroziak </h2>
                            <span>
                                Marta is the visionary and chief designer at Stuffed Pals.
                                Her passion for delivering joy to children worldwide drives the company's creative
                                spirit.
                                With a keen eye for design and a heart full of dreams, she has led Stuffed Pals from a
                                small workshop to an international brand.
                            </span>
                            <div class="section-social-media">
                                <a target="_blank" href="https://www.linkedin.com" src="www.linkedin.com"><img
                                        class="hyperlink_icon" src="../assets/icons/linkedin_icon.png"
                                        alt="LinkedIn Icon"></img></a>
                                <a target="_blank" href="https://www.instagram.com" src="www.instagram.com"><img
                                        class="hyperlink_icon" src="../assets/icons/instagram_icon.png"
                                        alt="Instagram Icon"></img></a>
                                <a target="_blank" href="https://www.facebook.com" src="www.facebook.com"><img
                                        class="hyperlink_icon" src="../assets/icons/facebook_icon.png"
                                        alt="Facebook Icon"></img></a>
                            </div>
                        </div>
                    </div>
                    <div class="section-image-display-element">
                        <img src="../assets/team-photos/ourteam_2.jpg" alt="Marta Ambroziak's photo"></img>
                        <div class="section-image-display-element-description">
                            <h3> CTO & Lead Programmer </h3>
                            <h2> Marta Ambroziak </h2>
                            <span>
                                As the technological architect of Stuffed Pals, Marta ensures all digital aspects of
                                our operations run smoothly.
                                Her expertise in IT infrastructure and passion for innovation have been crucial in
                                building the robust online presence of Stuffed Pals.
                            </span>
                            <div class="section-social-media">
                                <a target="_blank" href="https://www.linkedin.com" src="www.linkedin.com"><img
                                        class="hyperlink_icon" src="../assets/icons/linkedin_icon.png"
                                        alt="LinkedIn Icon"></img></a>
                                <a target="_blank" href="https://www.instagram.com" src="www.instagram.com"><img
                                        class="hyperlink_icon" src="../assets/icons/instagram_icon.png"
                                        alt="Instagram Icon"></img></a>
                                <a target="_blank" href="https://www.facebook.com" src="www.facebook.com"><img
                                        class="hyperlink_icon" src="../assets/icons/facebook_icon.png"
                                        alt="Facebook Icon"></img></a>
                            </div>
                        </div>
                    </div>
                    <div class="section-image-display-element">
                        <img src="../assets/team-photos/ourteam_3.jpg" alt="Marta Ambroziak's photo"></img>
                        <div class="section-image-display-element-description">
                            <h3> Lead Designer </h3>
                            <h2> Marta Ambroziak </h2>
                            <span>
                                Marta, the creative soul of our team, brings each plushie to life with her
                                extraordinary design skills.
                                She's the mastermind behind our signature customizable plushies, ensuring that every
                                piece is both adorable and unique.
                            </span>
                            <div class="section-social-media">
                                <a target="_blank" href="https://www.linkedin.com" src="www.linkedin.com"><img
                                        class="hyperlink_icon" src="../assets/icons/linkedin_icon.png"
                                        alt="LinkedIn Icon"></img></a>
                                <a target="_blank" href="https://www.instagram.com" src="www.instagram.com"><img
                                        class="hyperlink_icon" src="../assets/icons/instagram_icon.png"
                                        alt="Instagram Icon"></img></a>
                                <a target="_blank" href="https://www.facebook.com" src="www.facebook.com"><img
                                        class="hyperlink_icon" src="../assets/icons/facebook_icon.png"
                                        alt="Facebook Icon"></img></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-image-display-buttons">
                <button class="image-display-button image-display-button-active"></button>
                <button class="image-display-button"></button>
                <button class="image-display-button"></button>
            </div>
        </section>
    </main>
    <?php include "../newsletter/newsletter_form.php"; ?>
    <?php include "../site_static_parts/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../newsletter/newsletter_updater.js"></script>
    <script src="ourteam_slider.js"></script>
</body>

</html>