$(document).ready(function() {
    $("#overlay-cancel").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: '../cart_page/cancel_reservation_sender.php',
            type: 'GET',
            success: function() {
                location.reload();
            },
            error: function() {
                alert("Error during cancellation.");
            }
        });
    });

    $("#overlay-close").click(function() {
        $("#overlay").css("display", "none");
    });
});