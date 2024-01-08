$(document).ready(function() {
    // Function to reload addresses
    function loadAddresses() {
        $.ajax({
            url: "../../../user_pages/user_profile/user_address/user_address_loader.php",
            success: function(response) {
                $("#user-profile-option").html(response);
            }
        });
    }

    // Deleting address
    $(document).on("click", ".delete-address-button", function() {
        var addressId = $(this).attr("user-address-id");
        var buttonClicked = $(this);
            $.ajax({
                type: "POST",
                url: "../../../user_pages/user_profile/user_address/user_address_delete_sender.php",
                data: {
                    user_address_id: addressId
                },
                dataType: "json",
                success: function(response) {
                    if(response.status == 2) {
                        window.location.href = "../../../user_pages/user_login/user_login.php";
                    }
                    var formStatus = buttonClicked.closest('.section-row').find(".form-result[user-address-id='" + addressId + "']");
                    formStatus.html(response.msg).show();
                    setTimeout(function() { formStatus.html("") }, 500);
                    setTimeout(function() {
                        loadAddresses();
                    }, 600);
                },
                error: function(xhr, status, error) {
                    var formStatus = buttonClicked.closest('.section-row').find(".form-result[user-address-id='" + addressId + "']");
                    formStatus.html("There was an error processing your request.").show();
                    setTimeout(function() { formStatus.html("") }, 500);
                }
            });
    });

    // Loading address function
    loadAddresses();
});
