$(document).ready(function() {
    $("#newsletter-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/php_scripts/newsletter_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#newsletter-status").html(response.msg).show().delay(5000).fadeOut();
                if(response.status == 1) {
                    $("#newsletter-form").trigger("reset");
                }
            },
            error: function(xhr, status, error) {
                $("#newsletter-status").html("<p class='status_err'>There was an error processing your subscription.</p>").show().delay(5000).fadeOut();
            }
        });
    });
});