$(document).ready(function() {
    $(document).on("submit", ".add-to-cart-form", function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();

        var addToCartButton = form.find("[name='add-to-cart-button']");
        addToCartButton.prop("disabled", true);
        addToCartButton.find(".dots-5").show();
        addToCartButton.contents().first().replaceWith(""); 

        var formStatus = form.siblings(".form-result").find(".form-result-status");
        formStatus.hide();

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: data,
            dataType: "json",
            success: function(response) {
                formStatus.html(response.msg).show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
                addToCartButton.find(".dots-5").hide(); 
                addToCartButton.text("ADD TO CART");
                
                if (response.status === 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
            },
            error: function(xhr, status, error) {
                formStatus.html("There was an error processing your request.").show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
                addToCartButton.find(".dots-5").hide();
                addToCartButton.text("ADD TO CART");
            }
        });
    });
});