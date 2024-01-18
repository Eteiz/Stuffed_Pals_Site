<section id="newsletter" class="image-background">
    <div class="header-content section-rows white-background default-box-shadow">
        <div class="section-header">
            <h1>Join Our Newsletter!</h1>
            <h4>🔔 Keep in the loop with the latest news and exclusive offers from Stuffed Pals by providing your email address.</h4>
        </div>
        <div class="form-section">
            <form id="newsletter-form" action="../newsletter/newsletter_sender.php" method="post">
                <h3>Email address<span class="alert">*</span></h3>
                <label for="email-field" class="form-field">
                    <input type="email" id="email" name="email" required placeholder="Email Address" maxlength="255"
                        autocomplete="email">
                </label>
                <label for="consent" class="form-field section-rows">
                    <input type="checkbox" id="consent" name="consent" required>
                    <h4>I consent to Stuffed Pals using my email for communication purposes.<span class="alert">*</span></h4>
                </label>
                <button class="hyperlink_button" type="submit" name="subscribe-button" title="Subscribe to newsletter">
                    <div class="button-text">Subscribe</div>
                    <div class="dots-5" style="display: none;"></div>
                </button>
                <div class="form-result"></div>
            </form>
        </div>
    </div>
</section>