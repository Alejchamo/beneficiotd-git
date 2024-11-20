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

    // Recoger datos del formulario de login
    $correo_electronico = $_POST['correo_electronico'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar que los campos no estén vacíos
    if (empty($correo_electronico) || empty($password)) {
        throw new Exception("Por favor, completa todos los campos.");
    }

    // Preparar la consulta SQL para buscar al usuario
    $sql = "SELECT password, tipo_usuario FROM registros WHERE correo_electronico = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincular el parámetro de correo electrónico
    $stmt->bind_param("s", $correo_electronico);

    // Ejecutar la consulta
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el usuario existe, obtener la contraseña hasheada y el tipo de usuario
        $stmt->bind_result($hashed_password, $tipo_usuario);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            // Login exitoso
            session_start();

            $_SESSION['correo_electronico'] = $correo_electronico;
            $_SESSION['tipo_usuario'] = $tipo_usuario;

            echo "Bienvenido, $tipo_usuario";
            header("Location: index.html"); // Redirige a una página de éxito
        } else {
            // Contraseña incorrecta
            throw new Exception("La contraseña es incorrecta.");
        }
    } else {
        // Usuario no encontrado
        throw new Exception("No se encontró una cuenta con ese correo electrónico.");
    }

} catch (Exception $e) {
    // Capturar y mostrar la excepción
    echo "Ocurrió un error: " . $e->getMessage();
}

// Cerrar la conexión
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>