<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <title>Newsletter | Stuffed Pals</title>
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
    <?php include 'site_parts\navbar.php'; ?>
    <main>
        <section class="newsletter_first_section">
            <div class="newsletter_first_section_card">
                <!-- TBA: Adding php variable that contains this text so there's no need to have two pages. SESSION NEEDED -->
                <h1> We're sorry! </h1>
                <h3> It seems that this email is already subscribed to our newsletter... </h3>
            </div>
        </section>
    </main>
    <?php include 'site_parts\footer.php'; ?>
</body>
</html>