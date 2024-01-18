$(document).ready(function() {
    function loadProducts() {
        $.ajax({
            url: "../../admin_pages/admin_products/admin_products_loader.php",
            success: function(response) {
                $("#admin-product-section").html(response);
            }
        });
    }

    $(document).on("click", ".remove-button", function() {
        var productId = $(this).attr("product-id");
        var buttonClicked = $(this);
            $.ajax({
                type: "POST",
                url: "../../admin_pages/admin_products/admin_products_delete_sender.php",
                data: {
                    product_id: productId
                },
                dataType: "json",
                success: function(response) {
                    var formStatus = buttonClicked.closest('.section-element').find(".form-result[product-id='" + productId + "']");
                    formStatus.html(response.msg).show();
                    setTimeout(function() { formStatus.html("") }, 500);
                    setTimeout(function() {
                        loadProducts();
                    }, 600);
                },
                error: function(xhr, status, error) {
                    var formStatus = buttonClicked.closest('.section-element').find(".form-result[product-id='" + productId + "']");
                    formStatus.html("There was an error processing your request.").show();
                    setTimeout(function() { formStatus.html("") }, 500);
                }
            });
    });
    loadProducts();
});