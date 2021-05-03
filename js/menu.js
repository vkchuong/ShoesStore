var click = document.getElementsByClassName("open-menu")[0];
var menu = document.querySelector("#st-container");
var pusher = document.querySelector(".st-pusher");
var close = document.querySelector(".close-menu");
var effect;

click.addEventListener("click", addClass);

pusher.addEventListener("click", closeMenu);
close.addEventListener("click", buttonClose);

function addClass(e) {
  effect = e.target.getAttribute("data-effect");
  menu.classList.toggle(effect);
  menu.classList.toggle("st-menu-open");
}

function closeMenu(el) {
  if (el.target.classList.contains("st-pusher")) {
    menu.classList.toggle(effect);
    menu.classList.toggle("st-menu-open");
  }
}
function buttonClose(el) {
  menu.classList.toggle(effect);
  menu.classList.toggle("st-menu-open");
}
