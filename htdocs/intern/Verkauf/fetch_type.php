<?php
include 'C:\xampp\htdocs\db_connect.php';

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

$query = "SELECT GeraetetypID, Geraetebezeichnung FROM Geraetetyp";
$result = sqlsrv_query($conn, $query);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

$types = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row['Geraetebezeichnung'] = utf8_encode($row['Geraetebezeichnung']);

    $types[] = $row;
}

header('Content-Type: application/json; charset=utf-8');

echo json_encode($types);
if (json_last_error() !== JSON_ERROR_NONE) {
    die('JSON-Fehler: ' . json_last_error_msg());
}
?>