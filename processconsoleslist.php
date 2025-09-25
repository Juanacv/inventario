<?php
if (isset($_SESSION['user'])) {
    $userId = base64_decode($_SESSION['user']);
    $connection = createConnection($connectionData);

    // Obtener la información del usuario
    $countConsoles = countConsoles($connection, $userId);
    $sumConsoles = getSumPricesConsoles($connection, $userId);
    $lastAdquisition = getLastConsoleAdquisition($connection, $userId);

    // Establecer la página actual, por defecto es 1
    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $currentPage = max($currentPage, 1); // Asegura que la página actual sea al menos 1

    // Calcular el inicio para la paginación
    $init = ($currentPage - 1) * ITEMSPERPAGE;

    // Obtener el término de búsqueda
    $search = isset($_GET['search']) ? filtering($_GET['search']) : "";

    // Obtener los resultados de consolas
    $resultsConsoles = getConsolesPagination($connection, $userId, $init, $search);

    // Verificar si se obtuvo algún resultado y calcular el total de páginas
    if ($resultsConsoles && $resultsConsoles->num_rows > 0) {
        $realConsolesShowed = $resultsConsoles->num_rows;
        $totalPages = ceil($realConsolesShowed / ITEMSPERPAGE);
        $currentPage = min($currentPage, $totalPages); // Asegura que no se exceda el total de páginas
    } else {
        $realConsolesShowed = 0;
        $totalPages = 1;
    }

    $next = $currentPage + 1;
    $prev = $currentPage - 1;
}

