<?php  
if (isset($_POST['genre']) && isset($_SESSION['user'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Location: http://localhost/inventario/dist/error.php');
        exit();
    }
    $messages = ['genre' => null, 'image' => null];
    $genre = filtering($_POST['genre']);

    // Validación del género
    $validationCode = validateGenre($genre);
    if (isset($genreErrors[$validationCode])) {
        $messages['genre'] = $genreErrors[$validationCode];
    }

    // Comprobar existencia solo si la validación no falló
    if (empty($messages['genre'])) {
        $existsCode = checkIfGenreExists($connection, $genre);
        if (isset($genreErrors[$existsCode])) {
            $messages['genre'] = $genreErrors[$existsCode];
        }
    }

    // Subir imagen y mapear posibles errores
    $uploadResult = uploadFile(GENRESDIR);
    if (is_int($uploadResult) && isset($imageErrors[$uploadResult])) {
        $messages['image'] = $imageErrors[$uploadResult];
    }

    if (empty($messages['genre']) && empty($messages['image'])) {
        if (!isset($_POST['genreid'])) {
            setGenre($connection, $genre, $uploadResult);
        } 
        // Redirigir al usuario al registro
        header('Location: http://localhost/inventario/dist/genres.php');
        exit(); // Es importante llamar a exit después de una redirección        
    }
}
?>