<?php
include 'C:\xampp\htdocs\db_connect.php';

$sql = "SELECT Mietgeraetetyp, MietpreisproTag, MarkenName FROM Mietgeraete JOIN Marke ON Mietgeraete.MarkenID = Marke.MarkenID";
$query = sqlsrv_query($conn, $sql);

$devices = [];
if ($query !== false) {
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $devices[] = $row;
    }
}
?>