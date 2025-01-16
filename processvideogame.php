<?php
if (isset($_POST['videogamename']) && isset($_SESSION['user'])) {
    $videogameName = filtering($_POST['videogamename']);
    $comment = filtering($_POST['comment']);
    $maker = filtering($_POST['maker']);
    $consoleId = intval(filtering($_POST['consoleid']));
    $genreId = intval(filtering($_POST['genreid']));
    if ($consoleId === 0) $messages['consoleid'] = $videogameConsoleErrors[$consoleId]; 
    if ($genreId === 0) $messages['genreid'] = $videogameGenreErrors[$genreId]; 
    $id = base64_decode($_SESSION['user']);
    $result = validateComment($comment);
    if (isset($commentErrors[$result])) $messages['comment'] = $commentErrors[$result];
    $price = $_POST['price'];
    $dateAdquisition = $_POST['dateadquisition'];
    $result = validateVideoGameName($videogameName);
    if (isset($videogamenameErrors[$result])) $messages['videogamename'] = $videogamenameErrors[$result];
    $connection = createConnection($connectionData);    
    if (!isset($_POST['videogameid'])) {
        $result = checkIfVideogameExists($connection, $videogameName, $id);
        if (isset($videogamenameErrors[$result])) $messages['videogamename'] = $videogamenameErrors[$result];
    }
    $result = validateMaker($maker);
    if (isset($makerErrors[$result])) $messages['maker'] = $makerErrors[$result];
    $result = validatePrice($price);
    if (isset($priceErrors[$result])) $messages['price'] = $priceErrors[$result];
    $result = validateDate($dateAdquisition);
    if ($result === FALSE)  $result = INVALIDDATE;
    if (isset($dateAdquisitionErrors[$result])) $messages['dateadquisition'] = $dateAdquisitionErrors[$result];
    $result = uploadFile(VIDEOGAMESDIR);
    if (is_int($result) && isset($imageErrors[$result])) $messages["image"] = $imageErrors[$result];
    if (empty($messages['image']) && empty($messages['dateadquisition']) && empty($messages['price'])
    && empty($messages['image']) && empty($messages['comment']) && empty($messages['genreid'] 
    && empty($messages['consoleid']))) {
        if (!isset($_POST['videogameid'])) {
            setVideogame($connection, $videogameName, $consoleId, $genreId, $result, $comment, $price, $dateAdquisition, $id);
        } else {
            $videogameId = intval($_POST['videogameid']);        
            updateVideogame($connection, $videogameName, $consoleId, $genreId, $result, $comment, $price, $dateAdquisition, $videogameId, $_POST['oldimage'], $id);
        }
        // Redirigir al usuario al listado
        header('Location: http://localhost/inventario/dist/videogames.php');
        exit(); // Es importante llamar a exit después de una redirección        
    }
}
if (isset($_GET['videogame'])) {
    $connection = createConnection($connectionData);
    $row = getVideogameById($connection, intval($_GET['videogame']));
    $consoles = fetchAllResults($connection, "SELECT id, consolename FROM consoles");
    $genres = fetchAllResults($connection, "SELECT id, genre FROM genres");
    $profile = array();
    if (strpos($_SERVER['PHP_SELF'],'view') !== FALSE) {
        $profile = getProfile($connection, $row['ownerid']);
    }
}
?>