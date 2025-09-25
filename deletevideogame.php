<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: http://localhost/inventario/dist/error.php');
        exit();
    }
    $connection = createConnection($connectionData);
    $videogameId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $videogame = getVideogameById($connection, $videogameId);
    if ($videogame && isset($videogame['ownerid']) && intval($videogame['ownerid']) === $ownerId) {
        deleteImage(VIDEOGAMESDIR.$videogame['image']);
        deleteVideogame($connection, $videogameId, $ownerId);
    }
    // Redirigir al usuario al listado de videojuegos
    header('Location: http://localhost/inventario/dist/videogames.php');
    exit(); // Es importante llamar a exit después de una redirección    
}