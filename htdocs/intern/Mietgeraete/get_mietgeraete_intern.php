<?php
include 'C:\xampp\htdocs\db_connect.php';

$sql = "SELECT MietgeraetID, Mietgeraetetyp, MietpreisproTag, MarkenName, Bildpfad FROM Mietgeraete JOIN Marke ON Mietgeraete.MarkenID = Marke.MarkenID";
$query = sqlsrv_query($conn, $sql);

// Daten in einem Array speichern
$devices = [];
if ($query) {
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $devices[] = $row;
    }

}

// Für jedes Mietgerät die zugehörigen Vermietungen holen
$devicesWithRentals = [];
foreach ($devices as $device) {
    $sql_rentals = "SELECT Vermietungsbeginn, Vermietungsende FROM Vermietung WHERE MietgeraetID = '{$device['MietgeraetID']}'";
    $rental_query = sqlsrv_query($conn, $sql_rentals);
    $rentals = [];
    while ($rental_row = sqlsrv_fetch_array($rental_query, SQLSRV_FETCH_ASSOC)) {
        $rentals[] = $rental_row;
    }
    $device['rentals'] = $rentals;
    $devicesWithRentals[] = $device;
}

$sql_reservations = "SELECT 
VermietungsID,
Mietgeraete.Mietgeraetetyp,
Personen.Nachname AS KundeNachname,
Personen.Vorname AS KundeVorname,
Vermietung.Vermietungsbeginn,
Vermietung.Vermietungsende
FROM Vermietung
JOIN Mietgeraete ON Vermietung.MietgeraetID = Mietgeraete.MietgeraetID
JOIN Personen ON Vermietung.PID = Personen.PID
ORDER BY Vermietung.Vermietungsbeginn;";
$reservations_query = sqlsrv_query($conn, $sql_reservations);
$reservations = [];
while ($reservation_row = sqlsrv_fetch_array($reservations_query, SQLSRV_FETCH_ASSOC)) {
    $reservations[] = $reservation_row;
}
?>