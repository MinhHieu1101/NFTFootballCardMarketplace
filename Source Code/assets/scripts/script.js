//Variables
const hidden_menu = document.getElementById("hamburger");
const nav_bar = document.querySelector(".menu");

//Responsive navigation menu
function toggleHamburger() {
  nav_bar.classList.toggle("show-all");
}

hidden_menu.addEventListener("click", toggleHamburger);