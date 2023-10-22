<?php
include 'C:\xampp\htdocs\db_connect.php';

$sortimentId = $_POST['sortimentId'];
$seriennummer = $_POST['seriennummer'];

$query = "INSERT INTO Lagergeraete (SortimentID, Seriennummer) VALUES (?, ?)";
$params = array($sortimentId, $seriennummer);

$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    echo json_encode(array("status" => "error", "message" => "Eintrag konnte nicht gespeichert werden."));
} else {
    echo json_encode(array("status" => "success", "message" => "Eintrag erfolgreich gespeichert."));
}
?>