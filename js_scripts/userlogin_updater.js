$(document).ready(function() {
    $("#user-login-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $("[name='login-button']").prop('disabled', true).text('Logging in...');
        $("#user-login-form-status").hide();

        $.ajax({
            type: "POST",
            url: "php_scripts/userlogin_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#user-login-form-status").html(response.msg).show().delay(5000).fadeOut();
                $("[name='login-button']").prop('disabled', false).text('Log In');

                if(response.status === 1) {
                    $("#user-login-form").trigger("reset");
                    setTimeout(function() {
                        window.location.href = "../index.php";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                $("#user-login-form-status").html("<p class='status_err'>There was an error processing your login.</p>").show().delay(5000).fadeOut();
                $("[name='login-button']").prop('disabled', false).text('Log In');
            }
        });
    });
});