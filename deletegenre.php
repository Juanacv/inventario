<?php
if (isset($_GET['delete']) && isset($_SESSION['user'])) {
    if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: http://localhost/inventario/dist/error.php');
        exit();
    }
    $connection = createConnection($connectionData);
    $genreId = intval($_GET['delete']);
    $ownerId = intval(base64_decode($_SESSION['user']));
    $genre = getGenreById($connection, $genreId);
    if ($genre) {
        deleteImage(GENRESDIR.$genre['image']); 
        deleteGenre($connection, $genreId);
    }
    // Redirigir al usuario al listado de consolas
    header('Location: http://localhost/inventario/dist/genres.php');
    exit(); // Es importante llamar a exit después de una redirección    
}