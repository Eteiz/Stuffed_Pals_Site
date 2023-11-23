$(document).ready(function() {
    $("#contact-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        var sendMessageButton = $("[name='send-message-button']");
        sendMessageButton.prop('disabled', true);
        sendMessageButton.find('.dots-5').show();
        sendMessageButton.contents().first().replaceWith('');

        $("#contact-form-status").hide();

        $.ajax({
            type: "POST",
            url: "../php_scripts/contactform_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#contact-form-status").html(response.msg).show().delay(5000).fadeOut();
                sendMessageButton.prop('disabled', false);
                sendMessageButton.find('.dots-5').hide();
                sendMessageButton.contents().first().replaceWith('SEND MESSAGE');
                if(response.status == 1) {
                    $("#contact-form").trigger("reset");
                }
            },
            error: function(xhr, status, error) {
                $("#contact-form-status").html("<p class='status_err'>There was an error processing your form.</p>").show().delay(5000).fadeOut();
                sendMessageButton.prop('disabled', false);
                sendMessageButton.find('.dots-5').hide();
                sendMessageButton.contents().first().replaceWith('SEND MESSAGE'); 
            }
        });
    });
});