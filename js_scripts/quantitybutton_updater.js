const decreaseButton = document.getElementById('decrease-quantity-button');
  const increaseButton = document.getElementById('increase-quantity-button');
  const numberInput = document.getElementById('product-quantity');

  const min = 1;
  const max = 10; 

  decreaseButton.addEventListener('click', function() {
    let currentValue = parseInt(numberInput.value, 10);
    if (currentValue > min) {
      numberInput.value = currentValue - 1;
    }
  });

  increaseButton.addEventListener('click', function() {
    let currentValue = parseInt(numberInput.value, 10);
    if (currentValue < max) {
      numberInput.value = currentValue + 1;
    }
  });