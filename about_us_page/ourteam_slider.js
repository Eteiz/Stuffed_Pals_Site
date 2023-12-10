var buttonsArray = document.getElementsByClassName("image-display-button");
var slider = document.getElementById("our-team-slider");

buttonsArray[0].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("image-display-button-active");
    buttonsArray[0].classList.add("image-display-button-active");

    slider.style.transform = "translateX(0px)";
}
buttonsArray[1].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("image-display-button-active");
    buttonsArray[1].classList.add("image-display-button-active");

    slider.style.transform = "translateX(-865px)";
}
buttonsArray[2].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("image-display-button-active");
    buttonsArray[2].classList.add("image-display-button-active");

    slider.style.transform = "translateX(-1730px)";
}