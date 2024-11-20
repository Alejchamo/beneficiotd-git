<?php
// Iniciar la sesión al comienzo del archivo
session_start();

// Verificar si el usuario está autenticado como administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 'administrador') {
    // Si no es administrador, redirigir a la página principal
    header("Location: index.html"); 
    exit; // Asegurarse de que no se ejecute el resto del código
}

// Código para mostrar los documentos sigue aquí...
?>
