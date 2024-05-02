<?php
    // Iniciar sesión
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirigir al usuario a la página de mostrar anuncios si no es administrador
    header('Location: mostrarAnuncios.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Panel de Administración</title>
    <!-- Enlace a la hoja de estilos única para este panel -->
    <link rel="stylesheet" href="../assets/css/admin-panel.css">
    <!-- Incluir el script JavaScript -->
    <script src="../assets/js/script.js"></script>
    <style>
        /* Estilos específicos para el efecto de hover del encabezado */
        h2.hover-effect {
            transition: color 0.3s ease-in-out, opacity 0.3s ease-in-out; /* Transición suave para el color y la opacidad */
            cursor: pointer;
        }
        h2.hover-effect:hover {
            color: red; /* Cambiar el color al hacer hover */
        }
        /* Estilo para el texto oculto */
        h2.hover-effect.hidden {
            opacity: 0; /* Ocultar el texto estableciendo la opacidad en 0 */
        }

        
.responsive {
    width: 100vw;
    display: flex;
    justify-content: center; /* Centra los elementos horizontalmente */
    align-items: center; /* Centra los elementos verticalmente */
}

@media screen and (max-width: 767px) {
    .responsive {
        flex-direction: column; /* Cambia la dirección del flexbox a columna en dispositivos móviles */
    }
}
        
    </style>
</head>

<body>
    <!-- Encabezado con efecto de hover -->
    <h2 class="hover-effect" onmouseover="changeText(this)" onmouseout="revertText(this)" onclick="redirectHome(this)">Panel de Administración</h2>
    <!-- Contenedor de los iframes para crear y editar anuncios -->
    <div class="responsive">
        <!-- Iframe para crear anuncios -->
        <iframe id="crearAnunciosFrame" src="crearAnuncios.php" width="50%" height="600px" style="border: none;"></iframe>
        <!-- Iframe para editar anuncios -->
        <iframe id="editarAnunciosFrame" src="editarAnuncios.php" width="50%" height="600px" style="border: none;"></iframe>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Función para cambiar el texto del encabezado a "Volver" cuando se hace hover
        function changeText(element) {
            element.classList.add('hidden'); // Ocultar el texto actualmente visible
            setTimeout(function() { // Esperar un poco antes de cambiar el texto para que la transición tenga tiempo para ejecutarse
                element.innerText = "Volver";
                element.classList.remove('hidden'); // Mostrar el nuevo texto
            }, 200); // Duración de la transición CSS
        }

        // Función para revertir el texto del encabezado a "Panel de Administración" cuando se deja de hacer hover
        function revertText(element) {
            element.classList.add('hidden'); // Ocultar el texto actualmente visible
            setTimeout(function() { // Esperar un poco antes de cambiar el texto para que la transición tenga tiempo para ejecutarse
                element.innerText = "Panel de Administración";
                element.classList.remove('hidden'); // Mostrar el nuevo texto
            }, 200); // Duración de la transición CSS
        }

        // Función para recargar el iframe de editar anuncios cuando se recarga el iframe de crear anuncios
        function reloadEditarAnunciosOnFrameReload() {
            var iframe = document.getElementById('crearAnunciosFrame');
            iframe.onload = function() {
                var editarAnunciosIframe = document.getElementById('editarAnunciosFrame');
                editarAnunciosIframe.contentWindow.location.reload();
            };
        }

        // Llamar a la función al cargar la página
        window.onload = function() {
            reloadEditarAnunciosOnFrameReload();
        };

        // Función para redirigir al usuario cuando se hace clic en el encabezado
        function redirectHome(element) {
            window.location.href = "../index.php";
        }
    </script>
</body>

</html>
