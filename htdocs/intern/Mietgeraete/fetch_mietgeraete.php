<?php
include 'C:\xampp\htdocs\db_connect.php';

$query = "SELECT m.Mietgeraetetyp, m.MietpreisproTag, ma.MarkenName FROM Mietgeraete m INNER JOIN Marke ma ON m.MarkenID = ma.MarkenID";
$result = sqlsrv_query($conn, $query);

$mietgeraete = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    array_walk_recursive($row, function (&$item) {
        if (!mb_detect_encoding($item, 'utf-8', true)) {
            $item = utf8_encode($item);
        }
    });
    $mietgeraete[] = $row;
}
echo json_encode($mietgeraete);
?>