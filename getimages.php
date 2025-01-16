<?php
require_once "opts.php";
require_once "helpers.php";
// Obtener el nombre de la imagen desde la URL, por ejemplo: imagen.php?file=miimagen.jpg
$image = filteringImages($_GET['image']);
$type = intval(filtering($_GET['type']));
// Definir la ruta del directorio donde se almacenan las imágenes
$dir = "/";
if ($type == CONSOLES) {
    $route = CONSOLESDIR;
}
if ($type == PORTRAITS) {
    $route = PORTRAITSDIR;
}
if ($type == GENRES) {
    $route = GENRESDIR;
}
// Crear la ruta completa
$completeRoute = $route . $image;

// Verificar si el archivo existe
if (file_exists($completeRoute)) {
    // Obtener la extensión del archivo
    $extension = strtolower(pathinfo($completeRoute, PATHINFO_EXTENSION));

    // Establecer el tipo de contenido correcto
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            header('Content-Type: image/jpeg');
            break;
        case 'png':
            header('Content-Type: image/png');
            break;
        case 'svg':
            header('Content-Type: image/svg+xml');
            break;
        // Añadir más formatos si es necesario
    }

    // Leer y enviar el contenido del archivo
    readfile($completeRoute);
} else {
    // Enviar un código de respuesta 404 si la imagen no existe
    header("HTTP/1.0 404 Not Found");
}
?>