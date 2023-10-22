<?php
include 'C:\xampp\htdocs\db_connect.php';
$query = "SELECT
    Lagergeraete.LagergeraetID,
    Lagergeraete.SortimentID,
    Lagergeraete.Seriennummer,
    Lagergeraete.Verkauft,
    Marke.MarkenName,
    Sortiment.Modell,
    Geraetetyp.Geraetebezeichnung AS Geraetetyp,
    Sortiment.Verkaufspreis
FROM Lagergeraete
JOIN Sortiment ON Lagergeraete.SortimentID = Sortiment.SortimentID
JOIN Marke ON Sortiment.MarkenID = Marke.MarkenID
JOIN Geraetetyp ON Sortiment.GeraetetypID = Geraetetyp.GeraetetypID
WHERE Lagergeraete.Verkauft = 0";


$result = sqlsrv_query($conn, $query);

$data = array();

if ($result !== false) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>