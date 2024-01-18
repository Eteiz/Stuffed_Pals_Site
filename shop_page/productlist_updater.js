document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("filters-section");
    var productSection = document.getElementById("product-display-section");

    // Function to update product list
    function handleFormSubmit(event) {
        if (event) event.preventDefault();
        var formData = new FormData(form);

        fetch("../shop_page/productdisplay_loader.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            productSection.innerHTML = data;
        })
        .catch(error => console.error("Błąd:", error));
    }

    // Event listener for form submission
    if(form) {
        form.addEventListener("submit", handleFormSubmit);
    }

    // Event listeners for buttons
    var clearButton = document.querySelector("button[name='filters-clear-button']");
    var applyButton = document.querySelector("button[name='filters-apply-button']");

    if(clearButton) {
        clearButton.addEventListener("click", function(e) {
            form.reset();
            handleFormSubmit(e);
        });
    }

    if(applyButton) {
        applyButton.addEventListener("click", handleFormSubmit);
    }

    // Immediately load products when the page loads
    handleFormSubmit();
});
