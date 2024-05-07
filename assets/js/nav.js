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
    nav.style.backgroundColor = "rgba(0, 0, 0, 0.9)";
    nav.style.left = "0px";
  }
}

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".dropbtn")) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("show")) {
        openDropdown.classList.remove("show");
      }
    }
  }
};
