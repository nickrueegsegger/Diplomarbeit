<?php
include 'C:\xampp\htdocs\db_connect.php';

if (isset($_POST['deviceIds'])) {
    $deviceIds = json_decode($_POST['deviceIds']);

    foreach ($deviceIds as $id) {
        $query = "UPDATE Lagergeraete SET Verkauft = 1 WHERE LagergeraetID = ?";
        $params = array($id);
        $result = sqlsrv_query($conn, $query, $params);

        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}
exit;
?>