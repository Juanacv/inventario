<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    $imageRoute = VIDEOGAMESDIR.$_GET['image'];
    deleteImage($imageRoute);
    $connection = createConnection($connectionData);
    $videogameId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $videogame = getVideogameById($connection, $videogameId);
    deleteImage(VIDEOGAMESDIR.$videogame['image']);
    deleteVideogame($connection, $videogameId, $ownerId);
    // Redirigir al usuario al listado de videojuegos
    header('Location: http://localhost/inventario/dist/videogames.php');
    exit(); // Es importante llamar a exit después de una redirección    
}