<?php
include "C:/xampp/htdocs/db_connect.php";

$query = "SELECT mb.MitarbeiterbuchungsID, bm.Mvorname, bm.Mnachname, mb.Terminbeginn, mb.Terminende, Personen.Nachname AS KundeNachname,
          Personen.Vorname AS KundeVorname
          FROM Mitarbeiterbuchungen mb
          JOIN Personen ON mb.PID = Personen.PID
          INNER JOIN BuchbareMitarbeiter bm ON mb.MitarbeiterID = bm.MitarbeiterID";

$result = sqlsrv_query($conn, $query);

$termine = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $termine[] = $row;
}
?>