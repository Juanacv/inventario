<?php
session_start(); 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
function checkSession($connectionData) {
    $profile = array();
    if (isset($_SESSION['user'])) { 
        $id = base64_decode($_SESSION['user']);
        $connection = createConnection($connectionData);
        $profile = getProfile($connection, $id);
    }
    return $profile;
}