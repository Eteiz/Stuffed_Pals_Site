$(document).ready(function() {
    $("#user-delete-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        var deleteButton = $("[name='delete-button']");
        deleteButton.prop("disabled", true);
        deleteButton.find(".dots-5").show(); 
        deleteButton.contents().first().replaceWith(""); 

        $("#user-delete-form-status").hide();

        $.ajax({
            type: "POST",
            url: "../../user_pages/user_profile/userdelete_sender.php", 
            data: data,
            dataType: "json",
            success: function(response) {
                $("#user-delete-form-status").html(response.msg).show().delay(5000).fadeOut();
                deleteButton.prop("disabled", false);
                deleteButton.find(".dots-5").hide(); 
                deleteButton.text("DELETE ACCOUNT"); 
                if(response.status == 1) {
                    $("#user-delete-form").trigger("reset"); 
                    setTimeout(function() {
                        window.location.href = "../../../index.php";
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                $("#user-delete-form-status").html("There was an error processing your request.").show().delay(5000).fadeOut();
                deleteButton.prop("disabled", false);
                deleteButton.find(".dots-5").hide();
                deleteButton.text("DELETE ACCOUNT");
            }
        });
    });
});
