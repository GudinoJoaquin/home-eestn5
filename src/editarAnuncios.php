<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirigir al usuario a la página de mostrar anuncios si no es administrador
    header('Location: mostrarAnuncios.php');
    exit;
}

// Incluye los archivos necesarios
include '../config/server.php'; // Archivo de configuración del servidor
include '../config/anuncioObj.php'; // Archivo de configuración del objeto anuncio

// Procesar la eliminación de un anuncio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];
    $sql = "DELETE FROM anuncios WHERE id=?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $id);
    if ($statement->execute()) {
        // Recargar la página después de eliminar un anuncio
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "<p>Error al eliminar el anuncio: " . $conn->error . "</p>";
    }
}

// Procesar la edición de un anuncio existente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id = $_POST['editar'];
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $subtitulo = isset($_POST['subtitulo']) ? $_POST['subtitulo'] : '';
    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

    // Manejar la carga de una nueva imagen si se proporciona
    if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $ruta_imagen = '../imagenes/' . $imagen_nombre;

        // Mover el archivo de imagen a la carpeta de destino
        if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
            // Actualizar la ruta de la imagen en la base de datos
            $sql_imagen = "UPDATE anuncios SET imagen=? WHERE id=?";
            $statement_imagen = $conn->prepare($sql_imagen);
            $statement_imagen->bind_param("si", $ruta_imagen, $id);
            if ($statement_imagen->execute()) {
            } else {
                echo "<p>Error al actualizar la imagen: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error al cargar la nueva imagen.</p>";
        }
    }

    // Actualizar los demás campos del anuncio
    $sql = "UPDATE anuncios SET titulo=?, subtitulo=?, mensaje=? WHERE id=?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("sssi", $titulo, $subtitulo, $mensaje, $id);
    if ($statement->execute()) {
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "<p>Error al editar el anuncio: " . $conn->error . "</p>";
    }
}

// Obtener todos los anuncios
$sql = "SELECT * FROM anuncios ORDER BY id DESC"; // Consulta SQL para obtener todos los anuncios
$result = $conn->query($sql); // Ejecuta la consulta y guarda el resultado en una variable
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin-panel.css">
    <script src="../assets/js/script.js"></script>
</head>
<body>
    <div class="container">
        <?php
        // Verifica si hay anuncios disponibles
        if ($result->num_rows > 0) {
            // Itera sobre cada fila de resultados y muestra los anuncios
            while ($row = $result->fetch_assoc()) {
                // Muestra cada anuncio
                echo "<div class='anuncio'>";
                echo "<h3>" . $row['fecha'] . "</h3>";
                echo "<h3>" . $row['titulo'] . "</h3>";
                echo "<h4>" . $row['subtitulo'] . "</h4>";
                echo "<p>" . $row['mensaje'] . "</p>";
                // Formulario para editar el anuncio
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='editar' value='" . $row['id'] . "'>";
                echo "<button class='boton-editar-unico' type='button' onclick='mostrarFormulario(" . $row['id'] . ")'>Editar</button>";
                echo "</form>";
                // Formulario para eliminar el anuncio
                echo "<form method='post' style='display:inline;'>";
                echo "<input type='hidden' name='eliminar' value='" . $row['id'] . "'>";
                echo "<input class='boton-eliminar-unico' type='submit' value='Eliminar'>";
                echo "</form>";
                echo "</div>";

                // Formulario de edición para cada anuncio
                echo "<div class='formulario-edicion' id='formulario-edicion-" . $row['id'] . "'>";
                echo "<h3>Editar Anuncio</h3>";
                echo "<form method='post' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='editar' value='" . $row['id'] . "'>";
                echo "Título: <input type='text' name='titulo' value='" . $row['titulo'] . "'><br><br>";
                echo "Subtítulo: <input type='text' name='subtitulo' value='" . $row['subtitulo'] . "'><br><br>";
                echo "Mensaje: <textarea name='mensaje' rows='4' cols='50' style='resize: none;'>" . $row['mensaje'] . "</textarea><br><br>";
                // Input para cargar una nueva imagen
                echo "<input type='file' id='imagen-" . $row['id'] . "' name='imagen'  class='custom-file-upload'>";
                echo "<input class='boton-guardar' type='submit' value='Guardar'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            // Muestra un mensaje si no hay anuncios disponibles
            echo "<p class='sin-anuncios'>No hay anuncios disponibles.</p>";
        }
        ?>
    </div>
</body>
</html>
