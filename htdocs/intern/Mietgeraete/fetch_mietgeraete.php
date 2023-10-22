<?php
include 'C:\xampp\htdocs\db_connect.php';

$query = "SELECT m.Mietgeraetetyp, m.MietpreisproTag, ma.MarkenName FROM Mietgeraete m INNER JOIN Marke ma ON m.MarkenID = ma.MarkenID";
$result = sqlsrv_query($conn, $query);

$mietgeraete = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $mietgeraete[] = $row;
}
echo json_encode($mietgeraete);
?>