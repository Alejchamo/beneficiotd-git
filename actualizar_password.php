<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $nueva_password = password_hash($_POST['nueva_password'], PASSWORD_BCRYPT);

    $conexion = new mysqli('localhost', 'root', '', 'sistematd');
    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("UPDATE usuarios SET password = ?, token_recuperacion = NULL WHERE token_recuperacion = ?");
    $stmt->bind_param('ss', $nueva_password, $token);

    if ($stmt->execute()) {
        echo "Contraseña actualizada correctamente.";
    } else {
        echo "Error al actualizar la contraseña.";
    }

    $conexion->close();
}
?>
