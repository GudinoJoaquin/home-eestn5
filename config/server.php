<?php
// Datos de conexión
$servername = "localhost";
$username = "root"; // Usuario por defecto
$password = ""; // Sin contraseña por defecto
$database = "anuncios"; // Cambiar al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
