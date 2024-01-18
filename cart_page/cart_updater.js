$(document).ready(function() {
    var ajaxType="POST";
    var ajaxUrl="../cart_page/cart_handler.php";
    var ajaxDataType="json";

    // Function to load Cart
    function loadCart() {
        $.ajax({
            url: "../cart_page/cart_loader.php",
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
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                else if (response.status === 3) {
                    $("#overlay").css("display", "flex");
                }
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html(response.msg).show();
                setTimeout(function() { formStatus.html("") }, 500);
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html("There was an error processing your request.").show();
                setTimeout(function() { formStatus.html("") }, 500);
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
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                else if (response.status === 3) {
                    $("#overlay").css("display", "flex");
                }
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html(response.msg).show();
                setTimeout(function() { formStatus.html("") }, 500);
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html("There was an error processing your request.").show();
                setTimeout(function() { formStatus.html("") }, 500);
            }
        });
    });

    // Change quantity
    $(document).on("change", ".product-quantity-button", function() {
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
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                else if (response.status === 3) {
                    $("#overlay").css("display", "flex");
                }
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html(response.msg).show();
                setTimeout(function() { formStatus.html("") }, 500);
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html("There was an error processing your request.").show();
                setTimeout(function() { formStatus.html("") }, 500);
            }
        });
    });
  
    // Removing product
    $(document).on("click", ".remove-button", function() {
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
                if(response.status == 2) {
                    window.location.href = "../../user_pages/user_login/user_login.php";
                }
                else if (response.status === 3) {
                    $("#overlay").css("display", "flex");
                }
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html(response.msg).show();
                setTimeout(function() { formStatus.html("") }, 500);
                setTimeout(function() {
                    loadCart();
                }, 600);
            },
            error: function(xhr, status, error) {
                var formStatus = buttonClicked.closest("form").find(".form-result[data-product-id='" + productId + "']");
                formStatus.html("There was an error processing your request.").show();
                setTimeout(function() { formStatus.html("") }, 500);
            }
        });
    });

    loadCart();
});