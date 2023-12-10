function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password-field");
    var toggle = document.getElementById("toggle-password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggle.src = "../assets/icons/view_icon.png";
    } else {
        passwordInput.type = "password";
        toggle.src = "../assets/icons/hide_icon.png";
    }
}