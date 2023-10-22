<?php
include "C:/xampp/htdocs/db_connect.php";

if (isset($_GET['mitarbeiterID'])) {
    $mitarbeiterID = $_GET['mitarbeiterID'];

    $query = "SELECT Terminbeginn, Terminende FROM Mitarbeiterbuchungen WHERE MitarbeiterID = ?";
    $params = array($mitarbeiterID);
    $result = sqlsrv_query($conn, $query, $params);

    $events = [];
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $events[] = [
            'start' => $row['Terminbeginn']->format('Y-m-d H:i:s'),
            'end' => $row['Terminende']->format('Y-m-d H:i:s'),
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($events);
}
?>