<?php
// Iniciar la sesión y destruir todas las sesiones existentes
session_start();
session_destroy();

// Incluir los archivos de configuración del servidor y del objeto Anuncio
include '../config/server.php';
include '../config/anuncioObj.php';

// Definir la cantidad de anuncios por página
$anunciosPorPagina = 3;

// Consultar la cantidad total de anuncios en la base de datos
$sql = "SELECT COUNT(*) AS total FROM anuncios";
$result = $conn->query($sql);
$totalAnuncios = $result->fetch_assoc()['total'];

// Calcular el total de páginas necesarias para mostrar todos los anuncios
$totalPaginas = ceil($totalAnuncios / $anunciosPorPagina);

// Obtener el número de página actual o establecerlo en 1 si no se proporciona
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el desplazamiento (offset) para la consulta SQL según la página actual
$offset = ($paginaActual - 1) * $anunciosPorPagina;

// Consultar los anuncios para la página actual
$sql = "SELECT * FROM anuncios ORDER BY id DESC LIMIT $offset, $anunciosPorPagina";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Anuncios</title>
    <link rel="stylesheet" href="../assets/css/nav.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link id="theme-link" rel="stylesheet" href="../assets/css/mostrar-anuncios-light.css">
    <script src="../assets/js/nav.js"></script>
    <!--<a href="./login.php">Login</a> -->
</head>

<body>
    <header><nav id="navbar">
        <div id="logo" onclick="ocultar()">
          <img src="../assets/img/logo.svg" alt="Logo" />
          <p>Menu</p>
        </div>
        <div class="container">
          <div id="nav-content">
            <a href="../index.html">Inicio</a>
            <a href="./nosotros.html">Nosotros</a>
            <button onclick="myFunction()" class="dropbtn">
              Especialidades
            </button>
            <div id="myDropdown" class="dropdown-content">
              <a href="#">Informatica</a>
              <a href="#">Electronica</a>
              <a href="#">Construcciones</a>
            </div>
            <a href="https://eest5mdp.edu.ar/contacto.html">Contacto</a>
            <a href="./mostrarAnuncios.php">Anuncios</a>
          </div>
        </div>
      </nav>
    </header>
    <div class="parallax-completo">
        <?php
        // Verificar si hay resultados en la consulta
        if ($result->num_rows > 0) {
            // Iterar sobre los resultados y mostrar cada anuncio
            while ($row = $result->fetch_assoc()) {
                echo "<div class='anuncio-container'>";
                echo "<div class='contenedor-imagen'>";
                $extension = pathinfo($row["imagen"], PATHINFO_EXTENSION);
                if ($extension === 'pdf') {
                    echo "<a href='" . $row["imagen"] . "' target='_blank'><img src='https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg' alt='Imagen de anuncio'></a>";
                } else {
                    // Si no es un PDF, mostrar la imagen
                    echo "<a href='" . $row["imagen"] . "' target='_blank'>"; 
                     echo "<img src='" . $row["imagen"] . "'>";
                    echo "</a>";
                }                echo "</div>";
                echo "<div class='contenedor-contenido'>";
                echo "<h2>" . $row["titulo"] . "</h2>";
                echo "<h4>" . $row["subtitulo"] . "</h4>";
                echo "<p>" . $row["mensaje"] . "</p>";
                echo "</div>";
                echo "<div class='contenedor-fecha'>";
                echo "<h3>" . $row["fecha"] . "</h3>";
                echo "</div>";
                echo "</div>";
                }
            // Mostrar la paginación
            echo "<div class='paginacion'>";
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a href='?pagina=$i'>$i</a> "; // Enlace a cada página de anuncios
            }
            echo "</div>";

        } else {
            // Mostrar un mensaje si no se encontraron anuncios
            echo "No se encontraron anuncios.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    <script>
        // Obtener el botón y el enlace del tema
        const themeToggle = document.getElementById("theme-toggle");
        const themeLink = document.getElementById("theme-link");

        // Manejar el evento clic en el botón
        themeToggle.addEventListener("click", () => {
            // Obtener el valor actual del atributo href del enlace del tema
            const currentTheme = themeLink.getAttribute("href");

            // Alternar entre los temas oscuro y claro
            if (currentTheme === "../assets/css/mostrar-anuncios-light.css") {
                themeLink.setAttribute("href", "../assets/css/mostrar-anuncios-dark.css");
            } else {
                themeLink.setAttribute("href", "../assets/css/mostrar-anuncios-light.css");
            }
        });

    </script>
    </div>
</body>
<footer>
        <div class="footer-content">
            <div class="footer-nav">
                <ul>
                    <li><button href="#" class="contact-button">Contáctanos</button></li>
                </ul>
            </div>
            <div class="footer-names">
                <p>Escuela de Educación Técnica 5 Mar del Plata</p>
                <creadores>
                <a href="https://github.com/GudinoJoaquin" target="_blank" rel="noopener noreferrer">Joaquín Gudiño</a>
                <a href="https://github.com/FacundoCien" target="_blank" rel="noopener noreferrer">Facundo Cientofante</a>
                </creadores>
            </div>
            <div class="footer-social">
                <ul>
                    <li><a href="#"><img src="../assets/img/facebook.png" alt="Facebook"></a></li>
                    <li><a href="#"><img src="../assets/img/gorjeo.png" alt="Twitter"></a></li>
                    <li><a href="#"><img src="../assets/img/instagram.png" alt="Instagram"></a></li>
                </ul>
            </div>                    
        </div>
        
      </footer>
</html>