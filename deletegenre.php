<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    $imageRoute = GENRESDIR.$_GET['image'];
    deleteImage($imageRoute);
    $connection = createConnection($connectionData);
    $genreId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $genre = getGenreById($connection, $genreId);
    deleteImage(GENRESDIR.$genre['image']); 
    deleteGenre($connection, $genreId);
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/genres.php');
    exit(); // Es importante llamar a exit después de una redirección    
}