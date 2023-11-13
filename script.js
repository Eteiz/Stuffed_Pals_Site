var buttons = document.getElementsByClassName("ourteam_section_indicator_button");
var slider = document.getElementById("slider");

buttons[0].onclick = function() {
    for(i = 0; i < 3; i++) buttons[i].classList.remove("active");
    buttons[0].classList.add("active");

    slider.style.transform = "translateX(0px)";
}
buttons[1].onclick = function() {
    for(i = 0; i < 3; i++) buttons[i].classList.remove("active");
    buttons[1].classList.add("active");

    slider.style.transform = "translateX(-300px)";
}
buttons[2].onclick = function() {
    for(i = 0; i < 3; i++) buttons[i].classList.remove("active");
    buttons[2].classList.add("active");

    slider.style.transform = "translateX(-600px)";
}