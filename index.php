<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <title>Home | Stuffed Pals</title>
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
<body class="index_page">
	<?php include 'site_parts\navbar.php'; ?>
    <main>
		<section class="titular_section">
			<div class="titular_section_card">
				<h1> The way you </h1>
				<div class="text_slider">
					<div class="text_slider_element">
						<span>WANT IT</span>
						<span>NEED IT</span>
						<span>LOVE IT</span>
					</div>
    			</div>
				<h3> Creating a new best friend has never been easier and faster than now. What are you waiting for? </h3>
				<a class="hyperlink_button_black" href="#Browse"> Start now </a>
			</div>
		</section>

		<section class="presentation_section">
			<div class="presentation_section_container">
				<div class="presentation_section_description">
					<h2>Having a fluffy and cuddly friend is fun</h2>
					<span> Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam. 
						Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
					</span>
					<a class="hyperlink_button_purple" href="#Browse"> Browse collection </a>
				</div>
				<div class="presentation_section_list">
					<div class="presentation_section_list_element"> 
						<img src="img\eco_icon.png" alt="Eco icon"></img>
						<div class="presentation_section_list_element_text">
							<h3> ECO-FRIENDLY AND ETHICAL </h3>
							<span> The materials used for crafting our Pals are safe for the environment </span>
						</div>
					</div>
					<div class="presentation_section_list_element"> 
						<img src="img\heart_icon.png" alt="Heart icon"></img>
						<div class="presentation_section_list_element_text">
							<h3> PERSONALIZED COMFORT </h3>
							<span> Our Pals are fully customizable, tailored to meet individual preferences </span>
						</div>
					</div>
					<div class="presentation_section_list_element"> 
						<img src="img\quality_icon.png" alt="Quality icon"></img>
						<div class="presentation_section_list_element_text">
							<h3> HIGH-QUALITY </h3>
							<span> Stuffed Pals are designed with meticulous attention to detail and to ensure durability </span>
						</div>
					</div>
				</div>
				<img class="presentation_section_image" src="img\plush_1.png" alt="Plush_1 image"></img>
			</div>
		</section>

		<section class="tutorial_section">
			<h2> How can you create your perfect Stuffed Pal? </h2>
			<h3> We made sure that the process of making your perfect plushie is easy and intuitive. </h3>
			<div class="tutorial_section_steps">
				<div class="tutorial_section_steps_element">
					<img src = "img\teddy-bear_icon.png" alt = "Teddy-bear icon">
					<h3> Choose a plushie base </h3>
					<h4> Select one of many availables plush bases. </h4>
				</div>
				<div class="tutorial_section_steps_element">
					<img src = "img\clothes_icon.png" alt = "Clothes icon">
					<h3> Give them some clothes </h3>
					<h4> Select one of many availables plush bases. </h4>
				</div>
				<div class="tutorial_section_steps_element">
					<img src = "img\hair-clip_icon.png" alt = "Hair-clip icon">
					<h3> Maybe an accessory? </h3>
					<h4> Select one of many availables plush bases. </h4>
				</div>
			</div>
		</section>
		
		<section class="category_section">
			<h1> Our products </h1>
			<h3> From essentials to what makes your pal unique! </h3>
			<div class="category_section_categories">
				<div class="category_section_categories_element" style="background-color: #FF638B;">
					<img src="img\plush_2.png" alt="Plush_2 image">
					<a class="hyperlink_button_black" href="#Browse"> PAL BASES </a>
				</div>
				<div class="category_section_categories_element" style="background-color: #FFE2DD;">
					<img src="img\plush_1.png" alt="Plush_1 image">
					<a class="hyperlink_button_black" href="#Browse"> PAL CLOTHES </a>
				</div>
				<div class="category_section_categories_element" style="background-color: #D1FF88;">
					<img src="img\plush_3.png" alt="Plush_3 image">
					<a class="hyperlink_button_black" href="#Browse"> PAL ACCESORIES </a>
				</div>
			</div>
			<a class="hyperlink_button_black" href="#Browse"> ALL PRODUCTS </a>
		</section>

		<?php include 'site_parts\newsletter_form.php'; ?>
	</main>
	<?php include 'site_parts\footer.php'; ?>
</body>
</html>