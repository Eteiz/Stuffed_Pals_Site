<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <title>About us | Stuffed Pals</title>
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
    <main class="aboutus_page">
        <section class="titular_section">
            <div class="titular_section_description">
                <h1> About Stuffed Pals </h1>
                <span> In a world where screens often overshadow human touch and interactions, Stuffed Pals was conceived as a beacon of warmth and connection. 
                    We observed a rising tide of loneliness and sought a solution that was both tangible and heartwarming. 
                    Thus, the idea of customizable plush companions was born.
                </span>
            </div>
            <img src="img\plush_2.png" alt="Plush_2 image"></img> 
        </section>
        <section class="whowerare_section">
            <div class="whoweare_section_container">
                <div class="whoweare_section_panel" style="text-align:left;">
                    <img src="img\Aboutus_1.png" alt="Plushie closeup image"></img>
                    <div class="whoweare_section_panel_description">
                        <h2> Who we are? </h2>
                        <span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.
                        </span>
                    </div>
                </div>
                <div class="whoweare_section_panel" style="text-align:right;">
                    <div class="whoweare_section_panel_description">
                        <h2> Who do we do this? </h2>
                        <span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum.
                        </span>
                    </div>
                    <img src="img\Aboutus_2.png" alt="Plushie closeup image"></img>
                </div>
            </div>
        </section>
	</main>
	<?php include 'site_parts\footer.php'; ?>
</body>
</html>