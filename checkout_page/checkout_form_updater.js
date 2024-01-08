document.addEventListener('DOMContentLoaded', function() {
    const addressSelect = document.getElementById('user-address-select');

    addressSelect.addEventListener('change', function() {

        console.log("test");
        const addressId = this.value;

        if (addressId) {
            fetch('../checkout_page/get_address_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'addressId=' + encodeURIComponent(addressId)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('firstname-field').value = data.user_firstname || '';
                document.getElementById('lastname-field').value = data.user_lastname || '';
                document.getElementById('email-field').value = data.user_email || '';
                document.getElementById('phone-field').value = data.user_phone || '';
                document.getElementById('address-field').value = data.user_homeaddress || '';
                document.getElementById('city-field').value = data.user_city || '';
                document.getElementById('postalcode-field').value = data.user_postalcode || '';
                document.getElementById('state-field').value = data.user_state || '';
                document.getElementById('country-field').value = data.user_country || '';
            })
            .catch(error => {
                console.error('Error:', error);
                resetFormFields();
            });
        } else {
            resetFormFields();
        }
    });

    function resetFormFields() {
        document.getElementById('firstname-field').value = '';
        document.getElementById('lastname-field').value = '';
        document.getElementById('email-field').value = '';
        document.getElementById('phone-field').value = '';
        document.getElementById('address-field').value = '';
        document.getElementById('city-field').value = '';
        document.getElementById('postalcode-field').value = '';
        document.getElementById('state-field').value = '';
        document.getElementById('country-field').value = '';
    }
});
