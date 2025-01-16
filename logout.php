<?php
require_once "opts.php";

session_start();
session_unset();
session_destroy();
$connection = createConnection($connectionData);
$connection->close();
$connection = null;
header('Location: http://localhost/inventario/dist/index.php');
exit();