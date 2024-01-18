var faq = document.querySelectorAll("#faq-section .section-element-title");
for (var i = 0; i < faq.length; i++) {
    faq[i].addEventListener("click", function () {
        this.classList.toggle("active-faq");
        var body = this.nextElementSibling;
        body.classList.toggle("open");
    });
}