<?php
// Función para verificar si el usuario está logueado
session_start();
if (isset($_SESSION['correo_electronico'])) {
    // Si la clave existe, puedes acceder a ella y hacer lo que necesites
    $correoUsuario = $_SESSION['correo_electronico'];
    return true;
} else {
    // Si no existe la clave en $_SESSION, retorna 'false'
    echo "false";  // El correo no está en la sesión
}



?>
