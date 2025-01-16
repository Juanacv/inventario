<?php
$profile = checkSession($connectionData);
if (!empty($profile)) {
    $portrait = PORTRAITSDIR.$profile['image'];
}
else {
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/error.php');
    exit(); // Es importante llamar a exit después de una redirección
}