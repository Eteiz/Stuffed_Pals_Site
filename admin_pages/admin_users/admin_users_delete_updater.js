$(document).ready(function() {
    function loadUsers() {
        $.ajax({
            url: "../../admin_pages/admin_products/admin_users_loader.php",
            success: function(response) {
                $("#admin-user-section").html(response);
            }
        });
    }

    $(document).on("click", ".user-delete", function() {
        var userId = $(this).attr("user-id");
        var buttonClicked = $(this);
            $.ajax({
                type: "POST",
                url: "../../admin_pages/admin_users/admin_users_delete_sender.php",
                data: {
                    user_id: userId
                },
                dataType: "json",
                success: function(response) {
                    var formStatus = buttonClicked.closest('.section-element').find(".form-result[user-id='" + userId + "']");
                    formStatus.html(response.msg).show();
                    setTimeout(function() { formStatus.html("") }, 500);
                    setTimeout(function() {
                        loadUsers();
                    }, 600);
                },
                error: function(xhr, status, error) {
                    var formStatus = buttonClicked.closest('.section-element').find(".form-result[user-id='" + userId + "']");
                    formStatus.html("There was an error processing your request.").show();
                    setTimeout(function() { formStatus.html("") }, 500);
                }
            });
    });
    loadUsers();
});