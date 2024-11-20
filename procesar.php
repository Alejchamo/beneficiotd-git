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
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $cargo = $_POST['cargo'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';
    $municipio = $_POST['municipio'] ?? '';
    $placa_del_vehiculo = $_POST['placa_del_vehiculo'] ?? '';
    $correo_electronico = $_POST['correo_electronico'] ?? '';
    $cedula = $_POST['cedula'] ?? '';

    // Validar contraseñas
    if (empty($password) || empty($confirm_password)) {
        throw new Exception("Las contraseñas no pueden estar vacías.");
    }

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        throw new Exception("Las contraseñas no coinciden.");
    }

    // Solo insertar los datos necesarios si el tipo de usuario es "administrador"
    if ($tipo_usuario === 'administrador') {
        // Preparar la consulta SQL para insertar solo los datos requeridos
        $sql = "INSERT INTO registros (nombre, apellido, celular, cargo, password, tipo_usuario, correo_electronico) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        // Cifrar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vincular los parámetros
        $stmt->bind_param("sssssss", $nombre, $apellido, $celular, $cargo, $hashed_password, $tipo_usuario, $correo_electronico);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso";
        } else {
            throw new Exception("Error al registrar: " . $stmt->error);
        }
    } else if($tipo_usuario === 'usuario'){
        // Preparar la consulta SQL para insertar solo los datos requeridos
        $sql = "INSERT INTO registros (nombre, apellido, celular, municipio, placa_del_vehiculo, correo_electronico, password, tipo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la consulta SQL para insertar en la segunda tablas
        $sql2 = "INSERT INTO vehiculostd (cedula, placa, aplica_tarifa, notas) 
        VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt2 = $conn->prepare($sql2);
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }
        

        // Cifrar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $aplica_tarifa = (bool)rand(0, 1);
        $placa = $placa_del_vehiculo;
        $notas = 'Este carro aplica tarifa diferencial';

        // Vincular los parámetros
        $stmt->bind_param("ssssssss", $nombre, $apellido, $celular, $municipio, $placa_del_vehiculo, $correo_electronico, $password, $tipo_usuario );
        $stmt2->bind_param("ssss", $cedula, $placa, $aplica_tarifa, $notas);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso";
        } else {
            throw new Exception("Error al registrar: " . $stmt->error);
        }
        if ($stmt2->execute()) {
            echo "Registro exitoso";
        } else {
            throw new Exception("Error al registrar: " . $stmt2->error);
        }
    }else{
        echo "Tipo de usuario no válido para este registro.";
    }

} catch (Exception $e) {
    // Capturar y mostrar la excepción
    echo "Ocurrió un error: " . $e->getMessage();
}

// Cerrar la conexión
if (isset($stmt)) {
    $stmt->close();
}
if (isset($stmt2)) {
    $stmt2->close();
}
$conn->close();
?>