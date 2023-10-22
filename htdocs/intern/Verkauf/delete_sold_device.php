<?php
include 'C:\xampp\htdocs\db_connect.php';

if (isset($_POST['deviceIds'])) {
    $deviceIds = json_decode($_POST['deviceIds']);

    if (!empty($deviceIds)) {
        $ids = implode(',', $deviceIds);

        $query = "DELETE FROM Lagergeraete WHERE LagergeraetID IN ($ids)";
        $result = sqlsrv_query($conn, $query);

        if ($result) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
?>