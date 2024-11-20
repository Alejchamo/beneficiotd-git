<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'sistematd';
$username = 'root'; // Cambia esto según tu configuración de MySQL
$password = ''; // Cambia esto según tu configuración de MySQL

// Crear conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener usuarios
$sql = "SELECT nombre, apellido, celular, cargo, municipio, placa_del_vehiculo, clase_de_usuario, correo_electronico, password, confirm_password, tipo_usuario FROM registros";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrar los datos
if ($result->num_rows > 0) {
    // Mostrar los datos de cada fila
    while ($row = $result->fetch_assoc()) {
        echo "nombre: " . htmlspecialchars($row['nombre']) . " - ";
        echo "apellido: " . htmlspecialchars($row['apellido']) . " - ";
        echo "celular: " . htmlspecialchars($row['celular']) . " - ";
        echo "cargo: " . htmlspecialchars($row['cargo']) . " - ";
        echo "municipio: " . htmlspecialchars($row['municipio']) . " - ";
        echo "placa_del_vehiculo" . htmlspecialchars($row['placa_del_vehiculo']) . " - ";
        echo "clase_de_usuario: " . htmlspecialchars($row['clase_de_usuario']) . " - ";
        echo "correo_electronico: " . htmlspecialchars($row['correo_electronico']) . " - ";
        echo "password: " . htmlspecialchars($row['password']) . " - ";
        echo "confirm_password: " . htmlspecialchars($row['confirm_password']) . " - ";
        echo "tipo_usuario: " . htmlspecialchars($row['tipo_usuario']) . "<br>";
    }
} else {
    echo "No hay usuarios registrados";
}

// Cerrar la conexión
$conn->close();
?>