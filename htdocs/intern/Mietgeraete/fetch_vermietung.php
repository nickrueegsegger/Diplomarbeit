<?php
include 'C:\xampp\htdocs\db_connect.php';

$query = "SELECT Vermietungsbeginn, Vermietungsende, MietgeraetID FROM Vermietung";
$result = sqlsrv_query($conn, $query);

$events = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $events[] = array(
        'title' => 'Vermietet: ' . $row['MietgeraetID'],
        'start' => $row['Vermietungsbeginn'],
        'end' => $row['Vermietungsende']
    );
}
echo json_encode($events);
?>