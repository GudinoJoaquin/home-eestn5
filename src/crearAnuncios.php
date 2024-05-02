<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirigir al usuario a la página de mostrar anuncios si no es administrador
    header('Location: mostrarAnuncios.php');
    exit;
}

// Incluir archivos de configuración
include '../config/anuncioObj.php';
include '../config/server.php';

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $mensaje = $_POST['mensaje'];
    $fecha = date("Y-m-d H:i:s"); // Obtener la fecha y hora actuales

    // Manejar la carga de la imagen si se proporcionó
    if ($_FILES['imagen']['size'] > 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temporal = $_FILES['imagen']['tmp_name'];
        $ruta_imagen = '../imagenes/' . $imagen_nombre;

        // Mover el archivo de imagen a la carpeta de destino
        if (move_uploaded_file($imagen_temporal, $ruta_imagen)) {
            $imagen = $ruta_imagen;
        } else {
            $imagen = null;
        }
    } else {
        $imagen = null; // Si no se proporciona imagen, establecerla como null
    }

    // Crear un nuevo objeto Anuncio
    $nuevoAnuncio = new Anuncio(null, $fecha, $titulo, $subtitulo, $mensaje, $imagen);

    // Insertar el anuncio en la base de datos
    $sql = "INSERT INTO anuncios (fecha, titulo, subtitulo, mensaje, imagen) VALUES (?, ?, ?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param("sssss", $nuevoAnuncio->fecha, $nuevoAnuncio->titulo, $nuevoAnuncio->subtitulo, $nuevoAnuncio->mensaje, $nuevoAnuncio->imagen);

    if ($statement->execute()) {
        // Limpiar los campos después de enviar el formulario
        echo "<script>";
        echo "document.getElementById('formulario-anuncio').reset();";
        echo "</script>";
    } else {
        echo "<p>Error al guardar el anuncio en la base de datos: " . $conn->error . "</p>";
    }

    $statement->close();
}

// Cerrar conexión
$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin-panel.css"> <!-- Enlace a la hoja de estilos -->
    <script src="../assets/js/script.js"></script> <!-- Incluir el script JavaScript -->
</head>

<body>
    <div class="container">
        <div class="anuncio">
            <!-- Formulario para enviar un nuevo anuncio -->
            <form id="formulario-anuncio" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                enctype="multipart/form-data">
                Título: <input type="text" name="titulo" required><br><br>
                Subtítulo: <input type="text" name="subtitulo"><br><br>
                Mensaje: <textarea name="mensaje" rows="4" cols="50" style="resize: none;"></textarea><br><br>
                Imagen:
                <input type="file" class="custom-file-upload" id="imagen" name="imagen" accept="image/*,.pdf"> <!-- Input para cargar la imagen -->
                <input class="boton-enviar" type="submit" value="Enviar"> <!-- Botón de enviar el formulario -->
            </form>
        </div>
    </div>
</body>

</html>