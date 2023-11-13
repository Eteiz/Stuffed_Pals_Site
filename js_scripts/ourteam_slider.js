var buttonsArray = document.getElementsByClassName("ourteam_section_indicator_button");
var slider = document.getElementById("ourteam_section_slider");

buttonsArray[0].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("active");
    buttonsArray[0].classList.add("active");

    slider.style.transform = "translateX(0px)";
}
buttonsArray[1].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("active");
    buttonsArray[1].classList.add("active");

    slider.style.transform = "translateX(-1000px)";
}
buttonsArray[2].onclick = function() {
    for(i = 0; i < 3; i++) buttonsArray[i].classList.remove("active");
    buttonsArray[2].classList.add("active");

    slider.style.transform = "translateX(-2000px)";
}