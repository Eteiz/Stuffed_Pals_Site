$(document).ready(function() {
    // Delegacja zdarzeń - obsługa formularza dla dynamicznie dodanych elementów
    $(document).on("submit", ".add-to-cart-mini-form", function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();

        var addToCartButton = form.find("[name='add-to-cart-mini-button']");
        addToCartButton.prop("disabled", true);

        var formStatus = form.siblings(".form-result").find(".add-to-cart-mini-form-status");
        formStatus.hide();

        $.ajax({
            type: "POST",
            url: form.attr('action'), // Używa atrybutu 'action' z formularza
            data: data,
            dataType: "json",
            success: function(response) {
                formStatus.html(response.msg).show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
                
                if (response.status === 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
            },
            error: function(xhr, status, error) {
                formStatus.html("There was an error processing your request.").show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
            }
        });
    });
});
