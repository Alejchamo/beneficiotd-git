<?php
// Directorio donde se guardan los archivos
$target_dir = "uploads/";

// Abre el directorio y obtiene los archivos PDF
$files = scandir($target_dir);

// Filtra los archivos para obtener solo los PDFs
$pdf_files = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
});

// Verificar si hay archivos PDF disponibles
if (count($pdf_files) > 0) {
    echo "<h2>Archivos PDF Subidos:</h2><ul>";
    foreach ($pdf_files as $file) {
        echo "<li><a href='$target_dir/$file' target='_blank'>$file</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay archivos PDF disponibles.</p>";
}
?>

