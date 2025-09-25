<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: http://localhost/inventario/dist/error.php');
        exit();
    }
    $connection = createConnection($connectionData);
    $consoleId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $console = getConsoleById($connection, $consoleId);
    if ($console && isset($console['ownerid']) && intval($console['ownerid']) === $ownerId) {
        deleteImage(CONSOLESDIR.$console['image']);
        deleteConsole($connection, $consoleId, $ownerId);
    }
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/consoles.php');
    exit(); // Es importante llamar a exit después de una redirección    
}