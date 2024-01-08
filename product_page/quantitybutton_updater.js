document.addEventListener("DOMContentLoaded", function() {
  const decreaseButtons = document.getElementsByClassName("decrease-quantity-button");
  const increaseButtons = document.getElementsByClassName("increase-quantity-button");

  if (decreaseButtons.length > 0 && increaseButtons.length > 0) {
      const decreaseButton = decreaseButtons[0];
      const increaseButton = increaseButtons[0];
      const numberInput = document.querySelector(".product-quantity");

      decreaseButton.addEventListener("click", function() {
          let currentValue = parseInt(numberInput.value, 10);
          if (currentValue > parseInt(numberInput.min)) {
              numberInput.value = currentValue - 1;
          }
      });

      increaseButton.addEventListener("click", function() {
          let currentValue = parseInt(numberInput.value, 10);
          if (currentValue < parseInt(numberInput.max)) {
              numberInput.value = currentValue + 1;
          }
      });
  }
});
