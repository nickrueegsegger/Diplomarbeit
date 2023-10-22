<?php
include 'C:\xampp\htdocs\db_connect.php';


$data = json_decode($_POST['deviceIds']);

if (is_array($data)) {
    $idsToDelete = implode(',', $data);

    $query = "DELETE FROM Lagergeraete WHERE LagergeraetID IN ($idsToDelete)";

    $stmt = sqlsrv_query($conn, $query);

    if ($stmt === false) {
        echo json_encode(['success' => false]);
    } else {
        echo json_encode(['success' => true]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>