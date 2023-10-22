<?php
include 'C:\xampp\htdocs\db_connect.php';

if (isset($_POST['deviceIds'])) {
    $deviceIds = $_POST['deviceIds'];

    foreach ($deviceIds as $id) {
        $query = "DELETE FROM Sortiment WHERE SortimentID = ?";
        $params = array($id);
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    echo "Geräte erfolgreich gelöscht.";
} else {
    echo "Keine Geräte zum Löschen ausgewählt.";
}
?>