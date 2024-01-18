document.addEventListener("DOMContentLoaded", function() {
    const decreaseButton = document.getElementById("decrease-quantity-button");
    const increaseButton = document.getElementById("increase-quantity-button");
    const numberInput = document.getElementById("product-quantity-button");

    if (decreaseButton && increaseButton && numberInput) {
        decreaseButton.addEventListener("click", function(event) {
            event.preventDefault();
            let currentValue = parseInt(numberInput.value, 10);
            if (currentValue > parseInt(numberInput.min, 10)) {
                numberInput.value = currentValue - 1;
            }
        });

        increaseButton.addEventListener("click", function(event) {
            event.preventDefault();
            let currentValue = parseInt(numberInput.value, 10);
            if (currentValue < parseInt(numberInput.max, 10)) {
                numberInput.value = currentValue + 1;
            }
        });
    }
});
