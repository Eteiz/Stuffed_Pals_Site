$(document).ready(function() {
    $("#user-register-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        var registerButton = $("[name='register-button']");
        registerButton.prop('disabled', true);
        registerButton.find('.dots-5').show();
        registerButton.contents().first().replaceWith(''); 

        $("#user-register-form-status").hide();

        $.ajax({
            type: "POST",
            url: "../php_scripts/userregister_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#user-register-form-status").html(response.msg).show().delay(5000).fadeOut();
                registerButton.prop('disabled', false);
                registerButton.find('.dots-5').hide();
                registerButton.contents().first().replaceWith('SIGN UP');
                if(response.status === 1) {
                    $("#user-register-form").trigger("reset");
                    setTimeout(function() {
                        window.location.href = "../site_user_parts/user_login.php";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                $("#user-register-form-status").html("<p class='status_err'>There was an error processing your registration.</p>").show().delay(5000).fadeOut();
                registerButton.prop('disabled', false);
                registerButton.find('.dots-5').hide();
                registerButton.contents().first().replaceWith('SIGN UP');
            }
        });
    });
});
