<?php
function executeQuery($connection, $sql, $params = array()) {
    $stmt = $connection->prepare($sql);
    if (!empty($params)) {
        $paramTypes = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $paramTypes .= 'i'; // Integer type
            } elseif (is_float($param)) {
                $paramTypes .= 'd'; // Double type
            } elseif (is_string($param)) {
                $paramTypes .= 's'; // String type
            } else {
                $paramTypes .= 'b'; // Blob type
            }
        }
        $stmt->bind_param($paramTypes, ...$params);
    }
    $stmt->execute();
    if ($stmt->error) {
        return false;
    }
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function executeUpdate($connection, $sql, $params = array()) {
    $stmt = $connection->prepare($sql);
    if (!empty($params)) {
        $paramTypes = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $paramTypes .= 'i'; // Integer type
            } elseif (is_float($param)) {
                $paramTypes .= 'd'; // Double type
            } elseif (is_string($param)) {
                $paramTypes .= 's'; // String type
            } else {
                $paramTypes .= 'b'; // Blob type
            }
        }
        $stmt->bind_param($paramTypes, ...$params);
    }
    $stmt->execute();
    if ($stmt->error) {
        return false;
    }
    $stmt->close();
    return true;
}

function executeInsert($connection, $sql, $params = array()) {
    return executeUpdate($connection, $sql, $params);
}

function executeDelete($connection, $sql, $params = array()) {
    return executeUpdate($connection, $sql, $params);
}

// Fetch functions
function fetchSingleResult($connection, $sql, $params = array()) {
    $result = executeQuery($connection, $sql, $params);
    if ($result) {
        return $result->fetch_assoc();
    }
    return null;
}

function fetchSingleValue($connection, $sql, $params = array()) {
    $result = executeQuery($connection, $sql, $params);
    if ($result) {
        $row = $result->fetch_array();
        return $row ? $row[0] : null;
    }
    return null;
}

function fetchAllResults($connection, $sql, $params = array()) {
    $result = executeQuery($connection, $sql, $params);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function getRecords($connection, $table, $columns = "*", $conditions = "", $params = [], $orderBy = "", $limit = "") {
    $sql = "SELECT $columns FROM $table $conditions";
    if (!empty($orderBy)) $sql .= " ORDER BY $orderBy";
    if (!empty($limit)) $sql .= " LIMIT $limit";
    return executeQuery($connection, $sql, $params);
}

// Specific fetch function
function getRecordById($connection, $table, $id, $sql = '') {
    if (empty($sql)) $sql = "SELECT * FROM $table WHERE id = ?";
    return fetchSingleResult($connection, $sql, [$id]);
}

// Count functions
function countRecords($connection, $table, $conditions = "", $params = []) {
    $sql = "SELECT count(*) FROM $table $conditions";
    return intval(fetchSingleValue($connection, $sql, $params));
}

// Sum function
function sumPrices($connection, $table, $ownerId) {
    $sql = "SELECT sum(price) FROM $table WHERE ownerid = ?";
    return intval(fetchSingleValue($connection, $sql, [$ownerId]));
}

// Delete function
function deleteRecord($connection, $table, $conditions, $params) {
    $sql = "DELETE FROM $table WHERE $conditions";
    return executeUpdate($connection, $sql, $params);
}
?>