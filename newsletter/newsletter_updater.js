$(document).ready(function() {
    $("form[name='newsletter-form']").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "../newsletter/newsletter_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#newsletter-status").html(response.msg).show().delay(5000).fadeOut();
                if(response.status == 1) {
                    $("form[name='newsletter-form']").trigger("reset");
                }
            },
            error: function(xhr, status, error) {
                $("#newsletter-status").html("There was an error processing your subscription.").show().delay(5000).fadeOut();
            }
        });
    });
});