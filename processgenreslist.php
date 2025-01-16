<?php
if (isset($_SESSION['user'])) {
    $connection = createConnection($connectionData);
    $search = "";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } 
    $search = filtering($search);
    $totalGenres = countGenres($connection);
    $resultsGenres = getGenres($connection, $search);
}