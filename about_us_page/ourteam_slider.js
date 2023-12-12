var buttonsArray = document.getElementsByClassName("image-display-button");
var slider = document.getElementById("our-team-slider");

var sliderWidth = 865;
for (let i = 0; i < buttonsArray.length; i++) {
    buttonsArray[i].onclick = function() {
        // Deleting effect from other buttons
        for (let j = 0; j < buttonsArray.length; j++) {
            buttonsArray[j].classList.remove("image-display-button-active");
        }
        // Adding active class
        this.classList.add("image-display-button-active");
        // Moving slider
        var translateValue = -sliderWidth * i;
        slider.style.transform = "translateX(" + translateValue + "px)";
    }
}
