<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];
    // Verificar si el token es válido
    $conexion = new mysqli('localhost', 'root', '', 'sistematd');
    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE token_recuperacion = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo '
        <form method="post" action="actualizar_password.php">
            <input type="hidden" name="token" value="' . $token . '">
            <input type="password" name="nueva_password" placeholder="Nueva Contraseña" required>
            <input type="submit" value="Restablecer">
        </form>';
    } else {
        echo "Token inválido o expirado.";
    }

    $conexion->close();
}
?>
