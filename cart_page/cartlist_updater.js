$(document).ready(function() {
    var ajaxType="POST";
    var ajaxUrl="../cart_page/cartlist_action.php";
    var ajaxDataType="json";

    // Function to load Cart
    function loadCart() {
        $.ajax({
            url: "../cart_page/cartlist_loader.php",
            success: function(response) {
                $("#checkout").html(response);
            }
        });
    }

    // Decrease quantity
    $(document).on("click", ".decrease-quantity-button", function() {
        var productId = $(this).data("product-id");
        var buttonClicked = $(this);
        $.ajax({
            type: ajaxType,
            url: ajaxUrl,
            data: { 
                action: "subtract",
                product_id: productId,
                quantity: 1
            },
            dataType: ajaxDataType,
            success: function(response) {
                console.log(response);
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html(response.msg).show().delay(500).fadeOut();
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html("There was an error processing your request.").show().delay(500).fadeOut();
            }
        });
    });

    // Increase quantity
    $(document).on("click", ".increase-quantity-button", function() {
        var productId = $(this).data("product-id");
        var buttonClicked = $(this);
        $.ajax({
            type: ajaxType,
            url: ajaxUrl,
            data: { 
                action: "add",
                product_id: productId,
                quantity: 1 
            },
            dataType: ajaxDataType,
            success: function(response) {
                console.log(response);
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html(response.msg).show().delay(500).fadeOut();
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html("There was an error processing your request.").show().delay(500).fadeOut();
            }
        });
    });

    // Change quantity
    $(document).on("change", ".product-quantity", function() {
        var productId = $(this).data("product-id");
        var newQuantity = parseInt($(this).val());
        var buttonClicked = $(this);
        $.ajax({
            type: ajaxType,
            url: ajaxUrl,
            data: { 
                action: "update",
                product_id: productId,
                quantity: newQuantity 
            },
            dataType: ajaxDataType,
            success: function(response) {
                console.log(response);
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html(response.msg).show().delay(500).fadeOut();
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html("There was an error processing your request.").show().delay(500).fadeOut();
            }
        });
    });
  
    // Deleting product
    $(document).on("click", ".delete-button", function() {
        var productId = $(this).data("product-id");
        var buttonClicked = $(this);
        $.ajax({
            type: ajaxType,
            url: ajaxUrl,
            data: { 
                action: "remove",
                product_id: productId
            },
            dataType: ajaxDataType,
            success: function(response) {
                console.log(response);
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html(response.msg).show().delay(500).fadeOut();
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest(".section-row").find(".form-result[data-product-id='" + productId + "']").find(".form-result-status");
                formStatus.html("There was an error processing your request.").show().delay(500).fadeOut();
            }
        });
    });

    // Loading cart information function
    loadCart();
});