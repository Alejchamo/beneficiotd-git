<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'sistematd';
$username = 'root';
$password = '';

try {
    // Crear conexión a la base de datos
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar si hubo un error en la conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // Recoger datos del formulario
    $vehicle = $_POST['vehicle-id'] ?? null;

    // Verificar si se proporcionó un valor
    if ($vehicle === null) {
        echo "No se ha proporcionado un ID de vehículo o cédula.";
        exit();
    }

    // Convertir el valor ingresado a minúsculas para hacer una búsqueda insensible a mayúsculas
    $value = strtolower($vehicle);

    // Preparar la consulta para buscar en ambas columnas
    $stmt = $conn->prepare("SELECT * FROM vehiculostd WHERE LOWER(placa) = ? OR LOWER(cedula) = ?");
    $stmt->bind_param("ss", $value, $value);
    $stmt->execute();
    $result = $stmt->get_result();

    // Obtener todos los resultados
    $registros = [];
    while ($fila = $result->fetch_assoc()) {
        $registros[] = $fila;
    }

    $stmt->close();

    // Si se encuentran resultados, generar un mensaje
    if (!empty($registros)) {
        echo "Vehículo encontrado";  // Respuesta exitosa
    } else {
        echo "No se encontraron registros para el valor ingresado: " . $vehicle;
    }

} catch (Exception $e) {
    // Capturar y mostrar la excepción
    echo "Ocurrió un error: " . $e->getMessage();
}

$conn->close();
?>