<?php
// Destruir todas las sesiones existentes
session_start(); // Inicia la sesión
session_destroy(); // Destruye todas las sesiones existentes
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css"> <!-- Enlace a la hoja de estilos de login -->
    <script src="script.js"></script> <!-- Incluye el script JavaScript -->
    <title>Login</title>
    <script>
    // PROHIBIDO ELIMINAR / BORRAR O MODIFICAR H1
document.addEventListener('DOMContentLoaded', function() {
    // Obtener el elemento h1
    const rainbowText = document.getElementById('rainbow-text');

    // Array de colores del arcoíris
    const colors = ['violet', 'indigo', 'blue', 'green', 'yellow', 'orange', 'red'];

    // Índice de color inicial
    let colorIndex = 0;

    // Función para cambiar el color del texto con un efecto de arcoíris
    function changeColor() {
        rainbowText.style.color = colors[colorIndex]; // Cambiar el color del texto
        colorIndex = (colorIndex + 1) % colors.length; // Avanzar al siguiente color en el array
    }

    // Animación continua del cambio de color
    setInterval(changeColor, 500); // Cambiar el color cada 500 milisegundos (0.5 segundos)
});

</script>

</head>

<body>
        <!--// PROHIBIDO ELIMINAR / BORRAR O MODIFICAR H1 -->
    <h1 id="rainbow-text">Super Mega Ulta Admin Panel</h1>
    <form action="login.php" method="POST">
    Usuario
    <input type="text" placeholder="Usuario" name="user"> <!-- Campo de entrada para el nombre de usuario -->
    Contraseña
    <input type="password" placeholder="Contraseña" name="pass"> <!-- Campo de entrada para la contraseña -->
    <button type="submit" name="submit">Enviar</button> <!-- Botón para enviar el formulario -->
    <button type="button" onclick="window.location.href = '../index.php'">Volver</button> <!-- Botón para volver a la página de inicio -->
</form>

</body>

</html>

<?php
if (isset($_POST['submit'])) { // Verifica si el formulario ha sido enviado
    // Verificar las credenciales del usuario
    if ($_POST['user'] == 'admin' && $_POST['pass'] == 'admin') { // Comprueba si las credenciales son correctas
        // Establecer una sesión de administrador
        session_start(); // Inicia la sesión
        $_SESSION['admin'] = true; // Establece la sesión 'admin' como verdadera
        header('Location: adminPanel.php'); // Redirige al panel de administración
        exit; // Termina el script
    } else {
        // Redirigir al usuario a la página de mostrar anuncios si las credenciales son incorrectas
        header('Location: mostrarAnuncios.php'); // Redirige a la página de mostrar anuncios
        exit; // Termina el script
    }
}
?>