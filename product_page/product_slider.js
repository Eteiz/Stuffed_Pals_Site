document.addEventListener("DOMContentLoaded", function() {
    var displayer = document.querySelector(".image-displayer");
    var picker = document.querySelector(".image-carousel");
    var bigSlider = document.querySelector(".image-displayer-slider");

    var smallImages = picker.getElementsByTagName("img");
    for (var i = 0; i < smallImages.length; i++) {
        (function(index) {
            smallImages[i].addEventListener("click", function() {
                var displayerWidth = displayer.offsetWidth;
                bigSlider.style.transform = 'translateX(' + (-index * displayerWidth) + 'px)';

                for (var j = 0; j < smallImages.length; j++) {
                    smallImages[j].classList.remove("icon-focused");
                    smallImages[j].style.opacity = 0.5;
                }
                this.classList.add("icon-focused");
                this.style.opacity = 1; 
            });
        })(i);
    }

    smallImages[0].click();
});