<?php
// Directorio de destino
$target_dir = "uploads/";

// Verificamos si el formulario se envió por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los archivos
    $files = [
        "cedula" => $_FILES["cedula"],
        "carta_propiedad" => $_FILES["carta_propiedad"],
        "formulario" => $_FILES["formulario"],
        "licencia_conduccion" => $_FILES["licencia_conduccion"],
        "licencia_transito" => $_FILES["licencia_transito"]
    ];

    foreach ($files as $name => $file) {
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validaciones de archivo
        if ($file["size"] > 5000000) {
            echo "El archivo " . $name . " es demasiado grande.<br>";
            $uploadOk = 0;
        }
        if ($fileType != "pdf" && $fileType != "jpg" && $fileType != "png") {
            echo "Solo se permiten archivos PDF, JPG y PNG para " . $name . ".<br>";
            $uploadOk = 0;
        }

        // Intentar subir el archivo si las validaciones pasan
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "<span style='font-size: 25px;'>El archivo " . htmlspecialchars(basename($file["name"])) . " ha sido subido correctamente.</span><br>";
            } else {
                echo "Error al subir el archivo " . htmlspecialchars(basename($file["name"])) . ".<br>";
            }
        }
    }
}
?>
