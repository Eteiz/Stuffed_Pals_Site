$(document).ready(function() {
    $("#add-to-cart-form").on("submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        var addToCartButton = $("[name='add-to-cart-button']");
        addToCartButton.prop("disabled", true);
        addToCartButton.find(".dots-5").show();
        addToCartButton.contents().first().replaceWith(""); 

        $("#add-product-form-status").hide();

        $.ajax({
            type: "POST",
            url: "../product_page/add_to_cart.php",
            data: data,
            dataType: "json",
            success: function(response) {
                $("#add-product-form-status").html(response.msg).show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
                addToCartButton.find(".dots-5").hide(); 
                addToCartButton.text("ADD TO CART");
                
                if (response.status === 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
            },
            error: function(xhr, status, error) {
                $("#add-product-form-status").html("There was an error processing your request.").show().delay(5000).fadeOut();
                addToCartButton.prop("disabled", false);
                addToCartButton.find(".dots-5").hide();
                addToCartButton.text("ADD TO CART");
            }
        });
    });
});