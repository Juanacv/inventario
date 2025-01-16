<?php
if (isset($_POST['consolename']) && isset($_SESSION['user'])) {
    $consoleName = filtering($_POST['consolename']);
    $comment = filtering($_POST['comment']);
    $maker = filtering($_POST['maker']);
    $id = base64_decode($_SESSION['user']);
    $result = validateComment($comment);
    if (isset($commentErrors[$result])) $messages['comment'] = $commentErrors[$result];
    $price = $_POST['price'];
    $dateAdquisition = $_POST['dateadquisition'];
    $result = validateConsoleName($consoleName);
    if (isset($consolenameErrors[$result])) $messages['consolename'] = $consolenameErrors[$result];
    $connection = createConnection($connectionData);    
    if (!isset($_POST['consoleid'])) {
        $result = checkIfConsoleExists($connection,$consoleName, $id);
        if (isset($consolenameErrors[$result])) $messages['consolename'] = $consolenameErrors[$result];
    }
    $result = validateMaker($maker);
    if (isset($makerErrors[$result])) $messages['maker'] = $makerErrors[$result];
    $result = validatePrice($price);
    if (isset($priceErrors[$result])) $messages['price'] = $priceErrors[$result];
    $result = validateDate($dateAdquisition);
    if ($result === FALSE)  $result = INVALIDDATE;
    if (isset($dateAdquisitionErrors[$result])) $messages['dateadquisition'] = $dateAdquisitionErrors[$result];
    $result = uploadFile(CONSOLESDIR);
    if (is_int($result) && isset($imageErrors[$result])) $messages["image"] = $imageErrors[$result];
    if (empty($messages['image']) && empty($messages['dateadquisition']) && empty($messages['price'])
    && empty($messages['image']) && empty($messages['comment'])) {
        if (!isset($_POST['consoleid'])) {
            setConsole($connection, $consoleName, $maker, $price, $result, $comment, $dateAdquisition, $id);
        } else {
            $consoleId = intval($_POST['consoleid']);
            updateConsoleData($connection, $consoleName, $maker, $price, $result, $comment, $dateAdquisition, $consoleId, $_POST['oldimage'], $id);
        }
        // Redirigir al usuario al registro
        header('Location: http://localhost/inventario/dist/consoles.php');
        exit(); // Es importante llamar a exit después de una redirección        
    }
}
if (isset($_GET['console'])) {
    $connection = createConnection($connectionData);
    $row = getConsoleById($connection, intval($_GET['console']));
    $profile = array();
    if (strpos($_SERVER['PHP_SELF'],'view') !== FALSE) {
        $profile = getProfile($connection, $row['ownerid']);
    }
}
?>