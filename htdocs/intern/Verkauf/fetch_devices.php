<?php
include 'C:\xampp\htdocs\db_connect.php';

$query = "SELECT 
        v.SortimentID, 
        v.MarkenID, 
        m.MarkenName, 
        v.Modell, 
        gt.GeraetetypID, 
        gt.Geraetebezeichnung as Typ, 
        v.Verkaufspreis, 
        v.Bildpfad, 
        v.Einkaufspreis_exkl_mwst, 
        v.Beschreibung,
        COALESCE(COUNT(l.SortimentID), 0) as Lagerbestand  
    FROM Sortiment v 
    INNER JOIN Marke m ON m.MarkenID = v.MarkenID
    INNER JOIN Geraetetyp gt ON v.GeraetetypID = gt.GeraetetypID
    LEFT JOIN Lagergeraete l ON v.SortimentID = l.SortimentID AND l.Verkauft = 0  
    GROUP BY v.SortimentID, v.MarkenID, m.MarkenName, v.Modell, gt.GeraetetypID, gt.Geraetebezeichnung, v.Verkaufspreis, v.Bildpfad, v.Einkaufspreis_exkl_mwst, v.Beschreibung  ";

$result = sqlsrv_query($conn, $query);

$devices = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    array_walk_recursive($row, function (&$item) {
        if (!mb_detect_encoding($item, 'utf-8', true)) {
            $item = utf8_encode($item);
        }
    });
    $devices[] = $row;
}

echo json_encode($devices);
?>