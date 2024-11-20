<?php
$servername = "localhost";
$username = "root"; // Cambia si es necesario
$password = ""; // Cambia si es necesario
$dbname = "sistematd"; // Cambia al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($nombre, $apellido, $celular, $municipio, $placa_del_vehiculo, $correo_electronico, $password, $tipo_usuario);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
