<?php
require_once "execCRUD.php";

function createConnection($connectionData) {
    static $connection = null;
    if ($connection === null) {
        $connection = new mysqli($connectionData["host"], $connectionData["dbUser"], $connectionData["dbPassword"], $connectionData["db"]);
        if ($connection->connect_error) {
            die("Conexión fallida: " . $connection->connect_error);
            return false;
        }   
    }
    return $connection;
}

function getHash($connection, $username) {
    $sql = "SELECT hash FROM users where username = ?";
    return fetchSingleValue($connection, $sql, [$username]);   
}

function getId($connection, $username) {
    $sql = "SELECT id FROM users where username = ?";
    return fetchSingleValue($connection, $sql, [$username]);   
}

function getProfile($connection, $ownerId) {
    $sql = "SELECT username, image FROM users where id = ?";
    return fetchSingleResult($connection, $sql, [$ownerId]);    
}

function setUser($connection, $username, $hash, $image) {
    $sql = "INSERT INTO users (username, hash, image) VALUES (?, ?, ?)";
    executeInsert($connection, $sql, [$username, $hash, $image]);
}

function setConsole($connection, $consoleName, $maker, $price, $image, $comment, $dateAdquisition, $ownerId) {
    $sql = "INSERT INTO consoles (consolename, maker, price, image, comment, dateadquisition, ownerid) VALUES (?, ?, ?, ?, ?, ?, ?)";
    executeInsert($connection, $sql, [$consoleName, $maker, $price, $image, $comment, $dateAdquisition, $ownerId]);
}

function setVideogame($connection, $videogamename, $consoleId, $genreId, $image, $comment, $price, $dateAdquisition, $ownerId) {
    $sql = "INSERT INTO videogames (videogamename, consoleid, genreid, image, comment, price, dateadquisition, ownerid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    executeInsert($connection, $sql, [$videogamename, $consoleId, $genreId, $image, $comment, $price, $dateAdquisition, $ownerId]);
}

function setGenre($connection, $genre, $image) {
    $sql = "INSERT INTO genres (genre, image) VALUES (?, ?)";
    executeInsert($connection, $sql, [$genre, $image]);
}

function updateConsoleData($connection, $consoleName, $maker, $price, $image, $comment, $dateAdquisition, $id, $oldImage, $ownerId) {    
    $sql = "UPDATE consoles SET consolename=?, maker=?, price=?, image=?, comment=?, dateadquisition=? WHERE id = ? ANd ownerid = ?";
    executeUpdate($connection, $sql, [$consoleName, $maker, $price, $image, $comment, $dateAdquisition, $id, $ownerId]);
    deleteImage(CONSOLESDIR.$oldImage);
}

function updateVideogame($connection, $videogamename, $consoleId, $genreId, $image, $comment, $price, $dateAdquisition, $id, $oldImage, $ownerId) {
    $sql = "UPDATE videogames SET videogamename=?, consoleid=?, genreid=?, image=?, comment=?, price=?, dateadquisition=? WHERE id = ? AND ownerid = ?";
    executeUpdate($connection, $sql, [$videogamename, $consoleId, $genreId, $image, $comment, $price, $dateAdquisition, $id, $ownerId]);
    deleteImage(VIDEOGAMESDIR.$oldImage);
}

function checkIfUserExists($connection, $username) {
    if (empty($username)) return EMPTYERROR; // Error por username vacío
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    $count = fetchSingleValue($connection, $sql, [$username]); // Usa fetchSingleValue para obtener el resultado
    if ($count > 0) {
        return EXISTSERROR; // Usuario ya existe
    }
    return NOERROR; // No hay error, usuario no existe
}

function checkIfConsoleExists($connection, $consolename, $ownerId) {
    if (empty($consolename)) return EMPTYERROR;
    $sql = "SELECT count(*) FROM consoles where consolename = ? and ownerid = ?";
    $count = fetchSingleValue($connection, $sql, [$consolename, $ownerId]); // Usa fetchSingleValue para obtener el resultado
    if ($count > 0) {
        return EXISTSERROR; // Consola ya existe
    }
    return NOERROR; // No hay error, la consola no existe
}

function checkIfGenreExists($connection, $genre) {
    if (empty($genre)) return EMPTYERROR;
    $sql = "SELECT count(*) FROM genres where genre = ?";
    $count = fetchSingleValue($connection, $sql, [$genre]); // Usa fetchSingleValue para obtener el resultado
    if ($count > 0) {
        return EXISTSERROR; // Genero ya existe
    }
    return NOERROR; // No hay error, el genero no existe
}

function checkIfVideogameExists($connection, $videogamename, $ownerId) {
    if (empty($videogamename)) return EMPTYERROR;
    $sql = "SELECT count(*) FROM videogames where videogamename = ? and ownerid = ?";
    $count = fetchSingleValue($connection, $sql, [$videogamename, $ownerId]); // Usa fetchSingleValue para obtener el resultado
    if ($count > 0) {
        return EXISTSERROR; // El videojuego ya existe
    }
    return NOERROR; // No hay error, el videojuego no existe
}

function countConsoles($connection, $ownerId) {
    return countRecords($connection, "consoles", "WHERE ownerid = ?", [$ownerId]);
}

function countGenres($connection) {
    return countRecords($connection, "genres");
}

function countVideogames($connection, $ownerId) {
    return countRecords($connection, "videogames", "WHERE ownerid = ?", [$ownerId]);
}

function countUsersWithSameConsole($connection, $consoleName) {
    return countRecords($connection, "consoles", "WHERE consolename = ?", [$consoleName]);
}

function getGenres($connection, $search = '') {
    $conditions = !empty($search) ? "WHERE genre LIKE ?" : "WHERE 1=1";
    $params = !empty($search) ? ["%" . $search . "%"] : [];
    return getRecords($connection, "genres", "id, genre, image", $conditions, $params, "genre");
}

function getConsolesPagination($connection, $ownerId, $init, $search = '') {
    $conditions = "WHERE ownerid = ?";
    $params = [$ownerId];
    if (!empty($search)) {
        $conditions .= " AND (consolename LIKE ? OR maker LIKE ?)";
        $searchParam = "%" . $search . "%";
        $params = array_merge($params, [$searchParam, $searchParam]);
    }
    return getRecords($connection, "consoles", "id, consolename, maker, price, image, dateadquisition", $conditions, $params, "", "$init, " . ITEMSPERPAGE);
}

function getVideogamesPagination($connection, $ownerId, $init, $search = '') {
    $sql = "
        SELECT v.videogamename, c.consolename, g.genre, v.dateadquisition, v.image, v.price
        FROM videogames v
        INNER JOIN consoles c ON v.consoleid = c.id
        INNER JOIN genres g ON v.genreid = g.id
        WHERE v.ownerid = ?";
    $params = [$ownerId];
    if (!empty($search)) {
        $sql .= " AND (v.videogamename LIKE ? OR c.consolename LIKE ? OR g.genre LIKE ?)";
        $searchParam = "%" . $search . "%";
        $params = array_merge($params, [$searchParam, $searchParam, $searchParam]);
    }
    $sql .= " LIMIT $init, " . ITEMSPERPAGE;
    return executeQuery($connection, $sql, $params);
}

function getConsoleById($connection, $consoleId) {
    return getRecordById($connection, "consoles", $consoleId);
}

function getGenreById($connection, $genreId) {
    return getRecordById($connection, "genres", $genreId);
}

function getVideogameById($connection, $videogameId) {
    $sql = "
        SELECT v.*, c.consolename as consolename, g.genre as genre
        FROM videogames v
        INNER JOIN consoles c ON v.consoleid = c.id
        INNER JOIN genres g ON v.genreid = g.id
        WHERE v.id = ?";    
    return fetchSingleResult($connection, $sql, [$videogameId]);
}

function getSumPricesConsoles($connection, $ownerId) {
    return sumPrices($connection, "consoles", $ownerId);
}

function getSumPricesVideogames($connection, $ownerId) {
    return sumPrices($connection, "videogames", $ownerId);
}

function deleteConsole($connection, $consoleId, $ownerId) {
    return deleteRecord($connection, "consoles", "id = ? AND ownerid = ?", [$consoleId, $ownerId]);
}

function deleteGenre($connection, $genreId) {
    return deleteRecord($connection, "genres", "id = ?", [$genreId]);
}

function deleteVideogame($connection, $videogameId, $ownerId) {
    return deleteRecord($connection, "videogames", "id = ? AND ownerid = ?", [$videogameId, $ownerId]);
}

// Miscellaneous
function getLastConsoleAdquisition($connection, $ownerId) {
    $sql = "SELECT DATE_FORMAT(MAX(dateadquisition), '%d-%m-%Y') as formatted_date FROM consoles WHERE ownerid = ?";
    return fetchSingleValue($connection, $sql, [$ownerId]);
}
function getLastVideogameAdquisition($connection, $ownerId) {
    $sql = "SELECT DATE_FORMAT(MAX(dateadquisition), '%d-%m-%Y') as formatted_date FROM videogames WHERE ownerid = ?";
    return fetchSingleValue($connection, $sql, [$ownerId]);
}
?>