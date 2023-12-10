$(document).ready(function() {
    $("#user-register-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        var registerButton = $("[name='register-button']");
        registerButton.prop("disabled", true);
        registerButton.find(".dots-5").show();
        registerButton.text("");

        $("#user-register-form-status").hide();

        $.ajax({
            type: "POST",
            url: "../../user_pages/user_register/userregister_sender.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#user-register-form-status").html(response.msg).show().delay(5000).fadeOut();
                registerButton.prop("disabled", false);
                registerButton.find(".dots-5").hide();
                registerButton.text("SIGN UP");
                if(response.status == "1") {
                    $("#user-register-form").trigger("reset"); 
                    setTimeout(function() {
                        window.location.href = "../../user_pages/user_login/user_login.php";
                    }, 1500);
                }
            },
            error: function(xhr, status, error) {
                $("#user-register-form-status").html("There was an error processing your registration.").show().delay(5000).fadeOut();
                registerButton.prop("disabled", false);
                registerButton.find(".dots-5").hide();
                registerButton.text("SIGN UP");
            }
        });
    });
});
