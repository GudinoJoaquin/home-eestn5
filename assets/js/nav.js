function ocultar() {
  var navContent = document.getElementById("nav-content");
  var nav = document.getElementById("navbar");
  var logo = document.getElementById("logo").children;
  if (navContent.style.display === "flex") {
    navContent.style.display = "none";
    nav.style.backgroundColor = "transparent";
    nav.style.left = "-20px";
  } else {
    navContent.style.display = "flex";
    nav.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
    nav.style.left = "0px";
  }
}
