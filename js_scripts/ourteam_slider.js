var buttonsArray = document.getElementsByClassName("slider-button");
var slider = document.getElementById("our-team-section-slider");

buttonsArray[0].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("slider-button-active");
    buttonsArray[0].classList.add("slider-button-active");

    slider.style.transform = "translateX(0px)";
}
buttonsArray[1].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("slider-button-active");
    buttonsArray[1].classList.add("slider-button-active");

    slider.style.transform = "translateX(-1000px)";
}
buttonsArray[2].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("slider-button-active");
    buttonsArray[2].classList.add("slider-button-active");

    slider.style.transform = "translateX(-2000px)";
}