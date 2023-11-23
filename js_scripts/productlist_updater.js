document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('filters-form');
    var productSection = document.getElementById('product-section');

    // Function to update product list
    function handleFormSubmit(event) {
        if (event) event.preventDefault();
        var formData = new FormData(form);

        fetch('php_scripts/product_loader.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            productSection.innerHTML = data;
        })
        .catch(error => console.error('Błąd:', error));
    }

    // Event listener for form submission
    form.addEventListener('submit', handleFormSubmit);

    // Event listeners for buttons
    document.querySelector('button[name="clear-filters-button"]').addEventListener('click', function(e) {
        form.reset();
        handleFormSubmit(e);
    });
    document.querySelector('button[name="apply-filters-button"]').addEventListener('click', handleFormSubmit);

    // Check if page is loaded with a category filter and apply it immediately
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('selected_category')) {
        handleFormSubmit();
    }
});
