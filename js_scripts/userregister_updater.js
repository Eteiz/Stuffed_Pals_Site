$(document).ready(function() {
    $("#user-register-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $("[name='register-button']").prop('disabled', true).text('Registering...');
        $("#user-register-form-status").hide();

        $.ajax({
            type: "POST",
            url: "php_scripts/userregister_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#user-register-form-status").html(response.msg).show().delay(5000).fadeOut();
                $("[name='register-button']").prop('disabled', false).text('Register');
                
                if(response.status === 1) {
                    $("#user-register-form").trigger("reset");
                    setTimeout(function() {
                        window.location.href = "../user_login.php";
                    }, 3000);
                }
            },
            error: function(xhr, status, error) {
                $("#user-register-form-status").html("<p class='status_err'>There was an error processing your registration.</p>").show().delay(5000).fadeOut();
                $("[name='register-button']").prop('disabled', false).text('Register');
            }
        });
    });
});