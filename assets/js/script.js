// Obtener el botón y el enlace del tema
const themeToggle = document.getElementById("theme-toggle");
const themeLink = document.getElementById("theme-link");

// Manejar el evento clic en el botón
themeToggle.addEventListener("click", () => {
    // Obtener el valor actual del atributo href del enlace del tema
    const currentTheme = themeLink.getAttribute("href");

    // Alternar entre los temas oscuro y claro
    if (currentTheme === "../assets/css/light-theme.css") {
        themeLink.setAttribute("href", "../assets/css/dark-theme.css");
    } else {
        themeLink.setAttribute("href", "../assets/css/light-theme.css");
    }
});

// Función para mostrar el formulario de edición de un anuncio específico
function mostrarFormulario(id) {
    var anuncios = document.getElementsByClassName('anuncio');
    for (var i = 0; i < anuncios.length; i++) {
        anuncios[i].style.display = 'none';
    }
    var formulario = document.getElementById('formulario-edicion-' + id);
    formulario.style.display = 'block';
}

