<?php
function filtering($input) {
    $input = trim($input); // Elimina espacios antes y después de los datos
    $input = stripslashes($input); // Elimina backslashes \
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');; // Traduce caracteres especiales en entidades HTML
    return $input;
}
function filteringImages($input) {
    $input = basename($input); // Elimina cualquier ruta de directorio
    // Lista blanca de extensiones de archivo permitidas
    $allowedExtensions = IMAGEEXTENSIONS;
    // Comprobar la extensión del archivo
    $extension = strtolower(pathinfo($input, PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        // Manejar el caso de una extensión no permitida
        return null; // o manejarlo de otra manera
    }
    return filtering($input);
}
function validateUserName($username) {
    if (empty($username)) return EMPTYERROR;
    if (strlen($username) < MINUSERNAMELENGTH) return MINLONGERROR;
    if (strlen($username) > MAXUSERNAMELENGTH) return MAXLONGERROR;
    return NOERROR;
}
function validateGenre($genre) {
    if (empty($genre)) return EMPTYERROR;
    if (strlen($genre) < MINGENRELENGTH) return MINLONGERROR;
    if (strlen($genre) > MAXGENRELENGTH) return MAXLONGERROR;
    return NOERROR;
}
function validateConsoleName($consoleName) {
    if (empty($consoleName)) return EMPTYERROR;
    if (strlen($consoleName) < MINCONSOLENAMELENGTH) return MINLONGERROR;
    if (strlen($consoleName) > MAXCONSOLENAMELENGTH) return MAXLONGERROR;
    return NOERROR;
}
function validateVideoGameName($videoGameName) {
    if (empty($videoGameName)) return EMPTYERROR;
    if (strlen($videoGameName) < MINVIDEOGAMENAMELENGHT) return MINLONGERROR;
    if (strlen($videoGameName) > MAXVIDEOGAMENAMELENGTH) return MAXLONGERROR;
    return NOERROR;
}
function validateMaker($maker) {
    if (empty($maker)) return EMPTYERROR;
    if (strlen($maker) < MINMAKERLENGTH) return MINLONGERROR;
    if (strlen($maker) > MAXMAKERLENGTH) return MAXLONGERROR;
    return NOERROR;
}
function validateComment($comment) {
    if (strlen($comment) > MAXCOMMENTLENGTH) return MAXCOMMENTLENGTHERROR;
    return NOERROR;
}
function validatePrice($price) {
    if ($price==="") return EMPTYERROR;
    if ($price < MINPRICE) return MINPRICEERROR;
    if ($price > MAXPRICE) return MAXPRICEERROR;
    return NOERROR;
}
function validateDate($date) {
    if (empty($date)) return EMPTYERROR;
    // Convertir la fecha a un timestamp de Unix
    $timestamp = strtotime(str_replace("/", "-", $date));
    // Formatear la fecha para MySQL
    $fechaFormatoMySQL = date("Y-m-d", $timestamp);
    return $fechaFormatoMySQL;
}
function checkPassword($password) {
    if (empty($password)) return EMPTYERROR;
    return NOERROR;
}
function checkRepassword($password, $repassword) {
    if (empty($repassword)) return EMPTYERROR;
    if ($password !== $repassword) return REPASSWORDERROR;
    return NOERROR;
}
function encryptPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
function checkHash($password, $pwd_hashed) {
    return password_verify($password, $pwd_hashed);
}
function moveImage($arrayFile, $tmpName, $uploadDir) {
    // Comprobamos y renombramos el nombre del archivo
    $fileName = $arrayFile['filename'];
    $extension = $arrayFile['extension'];
    $fileName = preg_replace("/[^A-Z0-9._-]/i", "_", $fileName);
    $fileName = $fileName . rand(1, 100);
    // Desplazamos el archivo si no hay errores
    $fullName = $uploadDir.$fileName.".".$extension;
    move_uploaded_file($tmpName, $fullName);
    return $fileName.".".$extension;
}
function checkImage($fileName, $fileSize, $tmpName, $uploadDir) {
    $max_file_size = "1572864";
    $validExtensions = IMAGEEXTENSIONS;    
    $arrayFile = pathinfo($fileName);
    $extension = $arrayFile['extension'];
    // Comprobamos la extensión del archivo
    if(!in_array($extension, $validExtensions)){
        return EXTENSIONERROR;
    }
    // Comprobamos el tamaño del archivo
    if($fileSize > $max_file_size){
        return WEIGHTERROR  ;
    }
    list($width, $height, $type, $attr) = getimagesize($tmpName);
    if ($width > MAXWIDTHPX || $height > MAXHEIGTHPX) {
        return PXSIZEERROR;
    }
    return moveImage($arrayFile, $tmpName, $uploadDir);
}
function uploadFile($uploadDir) {
    if (!empty($_FILES['image']['name'])) {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];
        return checkImage($fileName, $fileSize, $tmpName, $uploadDir);
    } else {
        return FILERROR;
    }  
}
function deleteImage($image) {
    if (file_exists($image)) {
        unlink($image);
        return 1;
    }
    return 0;
}