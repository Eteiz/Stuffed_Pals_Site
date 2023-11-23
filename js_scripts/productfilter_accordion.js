var faq = document.querySelectorAll("#filters-section .section-content-row-header");
for (var i = 0; i < faq.length; i++) {
    faq[i].addEventListener("click", function () {
        this.classList.toggle("active-filter");
        var body = this.nextElementSibling;
        body.classList.toggle("open");
    });
}