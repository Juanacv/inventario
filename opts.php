<?php
define('NOERROR',0);
define('EMPTYERROR',1);
define('MINLONGERROR',2);
define('MAXLONGERROR',3);
define('EXISTSERROR',4);
define('REPASSWORDERROR',2);
define('EXTENSIONERROR',2);
define('WEIGHTERROR',3);
define('PXSIZEERROR',4);
define('FILERROR',1);
define('MAXUSERNAMELENGTH',55);
define('MINUSERNAMELENGTH',5);
define('MAXCONSOLENAMELENGTH',60);
define('MINCONSOLENAMELENGTH',5);
define('MAXVIDEOGAMENAMELENGTH',120);
define('MINVIDEOGAMENAMELENGHT',4);
define('MAXMAKERLENGTH',50);
define('MINMAKERLENGTH',4);
define('MAXPRICE',10000);
define('MINPRICE',0);
define('MINPRICEERROR',2);
define('MAXPRICEERROR',3);
define('INVALIDDATE',2);
define('PORTRAITSDIR','uploads/portraits/');
define('CONSOLESDIR','uploads/consoles/');
define('GENRESDIR','uploads/genres/');
define('VIDEOGAMESDIR','uploads/videogames/');
define('IMAGEEXTENSIONS',array("jpg", "jpeg", "png", "svg"));
define('MAXWIDTHPX',1000);
define('MAXHEIGTHPX',1000);
define('MAXCOMMENTLENGTH',500);
define('MAXCOMMENTLENGTHERROR',1);
define('ITEMSPERPAGE',8);
define('PAGESPERPAGINATION',5);
define('PORTRAITS',0);
define('CONSOLES',1);
define('GENRES',2);
define('VIDEOGAMES',3);
define('FORM',4);
define('MAXGENRELENGTH',20);
define('MINGENRELENGTH',3);

$connectionData = ["host"=>"localhost","dbUser"=>"root","dbPassword"=>"root","db"=>"inventory_new"];
$forms = [CONSOLES =>["formconsole.php","consola"],
    VIDEOGAMES =>["formvideogame.php","videojuego"]
];
$messages = [
    "username" => "",
    "password" => "",
    "repassword" => "",
    "consolename" => "",
    "price" => "",
    "image" => "",
    "comment" => "",
    "dateadquisition" => "",
    "maker" => "",
    "genre" => "",
    "videogamename" => "",
    "consoleid" => "",
    "genreid" => ""
];
$consolenameErrors = [
    "",
    "El nombre de la consola no debe estar vacío",
    "La longitud mínima del nombre de la consola debe ser 5",
    "La longitud máxima del nombre de la consola debe ser 60",
    "El nombre de consola ya existe"
];
$videogamenameErrors = [
    "",
    "El nombre del videojuego no debe estar vacío",
    "La longitud mínima del nombre del videojuego debe ser 5",
    "La longitud máxima del nombre de la consola debe ser 60",
    "El nombre de consola ya existe"
];
$videogameConsoleErrors = [
    "La consola a la que pertenece el videojuego no puede estar vacía"
];
$videogameGenreErrors = [
    "El género del videojuego no puede estar vacío"
];
$makerErrors = [
    "",
    "El nombre del fabricante no debe estar vacío",
    "La longitud mínima del fabricante debe ser 5",
    "La longitud máxima del fabricante debe ser 50"
];
$genreErrors = [
    "",
    "El nombre del género no debe estar vacío",
    "La longitud mínima del nombre del género debe ser 3",
    "La longitud máxima del nombre del género debe ser 20",
    "El nombre del género ya existe"
];
$priceErrors = [
    "",
    "El precio no debe estar vacío",
    "El precio no puede ser menor que 0",
    "El precio no puede ser mayor que 100000"
];
$usernameErrors = [
    "",
    "El nombre de usuario no debe estar vacío",
    "La longitud mínima del nombre de usuario debe ser 5",
    "La longitud máxima del nombre de usuario debe ser 55",
    "El nombre de usuario ya existe"
];
$passwordErrors = [
    "",
    "La contraseña no puede estar vacía"
];
$repasswordErrors = [
    "",
    "Debe repetir la contraseña",
    "Las contraseñas no coinciden"
];
$imageErrors = [
    "",
    "Error al subir el archivo",
    "Las extensiones válidas son jpeg, jpg, svg, y png",
    "El archivo no debe superar los 1.5Mb",
    "El archivo no pude superar los 1000x1000px"
];
$dateAdquisitionErrors = [
    "",
    "La fecha no puede estar vacía",
    "La fecha no es válida"
];

?>