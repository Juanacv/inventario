<?php  
if (isset($_POST['genre']) && isset($_SESSION['user'])) {
    $genre = filtering($_POST['genre']);
    $result = validateGenre($genre);
    if (isset($genreErrors[$result])) $messages['genre'] = $genreErrors[$result];

    $result = checkIfGenreExists($connection,$genre);
    if (isset($genreErrors[$result])) $messages['genre'] = $genreErrors[$result];

    $result = uploadFile(GENRESDIR);
    if (is_int($result) && isset($imageErrors[$result])) $messages["image"] = $imageErrors[$result];
    if (empty($messages['genre']) && empty($messages['image'])) {
        if (!isset($_POST['consoleid'])) {
            setGenre($connection, $genre, $result);
        } 
        // Redirigir al usuario al registro
        header('Location: http://localhost/inventario/dist/genres.php');
        exit(); // Es importante llamar a exit después de una redirección        
    }
}
?>