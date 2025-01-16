<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    $imageRoute = CONSOLESDIR.$_GET['image'];
    deleteImage($imageRoute);
    $connection = createConnection($connectionData);
    $consoleId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $console = getConsoleById($connection, $consoleId);
    deleteImage(CONSOLESDIR.$console['image']);
    deleteConsole($connection, $consoleId, $ownerId);
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/consoles.php');
    exit(); // Es importante llamar a exit después de una redirección    
}