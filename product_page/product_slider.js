document.addEventListener("DOMContentLoaded", function() {
    var displayer = document.querySelector(".icon-image-displayer");
    var picker = document.querySelector(".icon-image-slider");
    var bigSlider = document.querySelector(".main-image-slider");
    var isDown = false;
    var startX;
    var scrollLeft;

    picker.addEventListener("mousedown", function(e) {
        isDown = true;
        picker.classList.add("active");
        startX = e.pageX - displayer.offsetLeft;
        scrollLeft = displayer.scrollLeft;
    });

    document.addEventListener("mouseup", function() {
        isDown = false;
        picker.classList.remove("active");
    });

    document.addEventListener("mouseleave", function() {
        isDown = false;
        picker.classList.remove("active");
    });

    document.addEventListener("mousemove", function(e) {
        if (!isDown) return;
        e.preventDefault();
        var x = e.pageX - displayer.offsetLeft;
        var walk = (x - startX) * 0.7;
        displayer.scrollLeft = scrollLeft - walk;
    });

    var smallImages = picker.getElementsByTagName("img");
    for (var i = 0; i < smallImages.length; i++) {
        (function(index) {
            smallImages[i].addEventListener("click", function() {
                bigSlider.style.transform = 'translateX(' + (-index * 550) + 'px)';
                
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