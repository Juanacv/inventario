<?php
if (isset($_SESSION['user'])) {
    $userId = base64_decode($_SESSION['user']);
    $connection = createConnection($connectionData);

    // Obtener información sobre los videojuegos
    $countVideogames = countVideogames($connection, $userId);
    $sumVideogames = getSumPricesVideogames($connection, $userId);
    $lastAdquisition = getLastVideogameAdquisition($connection, $userId);

    // Establecer la página actual, por defecto es 1
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $currentPage = max($currentPage, 1); // Asegura que la página actual sea al menos 1

    // Calcular el inicio para la paginación
    $init = ($currentPage - 1) * ITEMSPERPAGE;

    // Obtener el término de búsqueda
    $search = isset($_GET['search']) ? filtering($_GET['search']) : "";

    // Obtener los resultados de los videojuegos
    $resultsVideogames = getVideogamesPagination($connection, $userId, $init, $search);

    // Verificar si se obtuvieron resultados
    if ($resultsVideogames && $resultsVideogames->num_rows > 0) {
        $resultsVideogamesShowed = $resultsVideogames->num_rows;
        $totalPages = ceil($resultsVideogamesShowed / ITEMSPERPAGE);
        $currentPage = min($currentPage, $totalPages); // Asegura que no se exceda el total de páginas
    } else {
        $resultsVideogamesShowed = 0;
        $totalPages = 1;
    }

    // Paginación
    $next = $currentPage + 1;
    $prev = $currentPage - 1;
}

