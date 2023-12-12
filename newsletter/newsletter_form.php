<section id="newsletter" class="image-background">
    <div class="section-container white-background default-box-shadow">
        <div class="section-header">
            <h1>SIGN UP!</h1>
            <h4> Stay up-to-date with Stuffed Pals newsletter and offers by entering your email.</h4>
        </div>
        <form id="newsletter-form" name="newsletter-form" action="../newsletter/newsletter_sender.php" method="post">
            <h3>Email address</h3>
            <input type="email" id="email" name="email" required placeholder="Email Address" maxlength="100"
                autocomplete="email">
            <label for="consent">
                <input type="checkbox" id="consent" name="consent" required>
                <h4>I agree to Stuffed Pals storing my email data and contacting me</h4>
            </label>
            <button class="hyperlink_button" type="submit" name="subscribe">SUBSCRIBE</button>
            <div class="form-result">
                <h4 id="newsletter-status"></h4>
            </div>
        </form>
    </div>
</section>