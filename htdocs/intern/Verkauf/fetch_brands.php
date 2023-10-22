<?php
include 'C:\xampp\htdocs\db_connect.php';

$query = "SELECT MarkenID, MarkenName FROM Marke";
$result = sqlsrv_query($conn, $query);

$brands = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $brands[] = $row;
}

echo json_encode($brands);
?>