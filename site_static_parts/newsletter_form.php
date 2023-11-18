<section id="newsletter">
    <div class="section-container white_background">
        <div class="section-header">
            <h1> SIGN UP! </h1>
            <h4> STAY UP-TO-DATE WITH STUFFED PALS NEWSLETTER AND OFFERS BY ENTERING YOUR EMAIL. </h4>
        </div>
        <!-- Script used: newsletter_script.php -->
        <form id="newsletter-form" name="newsletter-form" action="php_scripts/newsletter_sender.php" method="post">
            <h4>EMAIL ADDRESS</h4>
            <input type="email" id="email" name="email" required placeholder="Email Address" maxlength="100" autocomplete="email">

            <label for="consent">
				<input type="checkbox" id="consent" name="consent" required>
                <h4>I AGREE TO STUFFED PALS STORING MY DATA AND CONTACTING ME</h4>
            </label>

            <button class="hyperlink_button" type="submit" name="subscribe">SUBSCRIBE</button>
            <div class="newsletter-result">
                <h4 id="newsletter-status"></h4>
            </div>
        </form>
    </div>
</section>
