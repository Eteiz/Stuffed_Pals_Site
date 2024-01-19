
function handleFormSubmit(formId, buttonName, phpFunctionAddress, formType) {
    $(document).on("submit", "#" + formId, function(e) {
        
        e.preventDefault();
        console.log("Form submitted for ", formType);
        var form = $(this);
        var data = form.serialize();
        var formStatus = form.find(".form-result"); 

         var button = $("[name='" + buttonName + "']");
        var buttonText = button.find(".button-text");
        var buttonAnimation = button.find(".dots-5");

        buttonText.hide();
        buttonAnimation.show();
        button.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: phpFunctionAddress,
            data: data,
            dataType: "json",
            success: function(response) {
                formStatus.html(response.msg).show();
                setTimeout(function() { formStatus.html("") }, 3500);

                buttonText.show();
                buttonAnimation.hide();
                button.prop("disabled", false);

                if(response.status == 0) {
                    form.trigger("reset"); 
                    switch(formType) {
                        case "login":
                            setTimeout(function() {
                                window.location.href = "../../../index.php";
                            }, 1500);
                            break;
                        case "register":
                            setTimeout(function() {
                                window.location.href = "../../user_pages/user_login/user_login.php";
                            }, 1500);
                            break;
                        case "delete":
                            setTimeout(function() {
                                window.location.href = "../../../index.php";
                            }, 1500);
                            break;
                        case "logout":
                            setTimeout(function() {
                                window.location.href = "../../../index.php";
                            }, 1500);
                            break;
                        case "add-address":
                            setTimeout(function() {
                                window.location.href = "../../../user_pages/user_profile/user_profile.php";
                            }, 1500);
                            break;
                        case "edit-address":
                            setTimeout(function() {
                                 window.location.href = "../../../user_pages/user_profile/user_profile.php";
                            }, 1500);
                            break;  
                        case "create-order":
                            setTimeout(function() {
                                window.location.href = "../../../index.php";
                           }, 1500);
                           break; 
                        case "admin-login":
                            setTimeout(function() {
                                window.location.href = "../../../admin_pages/admin_dashboard.php";
                            }, 1500);
                            break;
                        case "admin-logout":
                            setTimeout(function() {
                                window.location.href = "../../../admin_pages/admin_login_page.php";
                            }, 1500);
                            break;
                        case "add-product":
                            setTimeout(function() {
                                window.location.href = "../../../admin_pages/admin_dashboard.php?content=products";
                            }, 1500);
                        case "edit-product":
                            setTimeout(function() {
                                window.location.href = "../../../admin_pages/admin_dashboard.php?content=products";
                            }, 1500);
                        case "edit-order":
                            setTimeout(function() {
                                window.location.href = "../../../admin_pages/admin_dashboard.php?content=orders";
                            }, 1500);
                        default:
                            break;
                    }
                }
            },
            error: function(xhr, status, error) {
                formStatus.html("There was an error processing your request.").show();
                setTimeout(function() { formStatus.html("") }, 3500);

                buttonText.show();
                buttonAnimation.hide();
                button.prop("disabled", false);
            }
        });
    });
}
