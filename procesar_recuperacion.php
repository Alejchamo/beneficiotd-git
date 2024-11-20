<?php

// Habilitar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir el correo electrónico desde el formulario
    $correo = $_POST['correo_electronico'];

    // 1. Conectar a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'sistematd');
    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    // 2. Verificar si el correo existe en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM registros WHERE correo_electronico = ?");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // 3. Generar un token único para la recuperación de contraseña
        $token = bin2hex(random_bytes(16));

        // 4. Guardar el token en la base de datos
        $stmt = $conexion->prepare("UPDATE registros SET token_recuperacion = ? WHERE correo_electronico = ?");
        $stmt->bind_param('ss', $token, $correo);
        if ($stmt->execute()) {
            // 5. Preparar el enlace y enviar el correo
            $enlace = "http://localhost/BENEFICIOTD/restablecer_password.php?token=$token";
            $mensaje = "Haga clic en el siguiente enlace para restablecer su contraseña: $enlace";
            $asunto = "Recuperación de Contraseña";
            $cabeceras = "From: no-reply@miempresa.com";

            if (mail($correo, $asunto, $mensaje, $cabeceras)) {
                echo '<p style="font-size: 25px;">Correo enviado correctamente. Revisa tu bandeja de entrada.</p>';
            } else {
                echo '<p style="font-size: 18px; color: red;">Error al enviar el correo.</p>';
            }
        } else {
            echo "Error al guardar el token de recuperación.";
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        }
    } else {
        // Si el correo no está registrado, mostrar un mensaje
        echo "El correo ingresado no está registrado.";
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
