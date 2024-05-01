function showContent(id) {
  // Ocultar todos los contenidos
  var contents = document.getElementsByClassName("especialidades-cont")[0]
    .children;
  for (var i = 0; i < contents.length; i++) {
    contents[i].style.display = "none";
  }

  // Mostrar el contenido deseado
  document.getElementById(id).style.display = "block";
}
