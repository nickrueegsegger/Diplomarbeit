<?php
include 'C:\xampp\htdocs\db_connect.php';

$markenID = $_POST['marke'];
$geraetetypID = $_POST['geraetebezeichnung'];
$modell = $_POST['modell'];
$einkaufspreis_exkl_mwst = $_POST['einkaufspreis'];
$verkaufspreis = $_POST['verkaufspreis'];
$beschreibung = $_POST['beschreibung'];


$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/intern/Verkauf/uploads/';
$uploadFile = $uploadDir . basename($_FILES['bild']['name']);


$relativePath = '/intern/Verkauf/uploads/' . basename($_FILES['bild']['name']);

if (move_uploaded_file($_FILES['bild']['tmp_name'], $uploadFile)) {

    $query = "INSERT INTO Sortiment (MarkenID, GeraetetypID, Modell, Verkaufspreis, Bildpfad, Einkaufspreis_exkl_mwst, Beschreibung) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($markenID, $geraetetypID, $modell, $verkaufspreis, $relativePath, $einkaufspreis_exkl_mwst, $beschreibung);

    $result = sqlsrv_query($conn, $query, $params);

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: verkaufsgeraete_intern.php"); // Zurück zur Hauptseite
} else {
    echo '<script>
        alert("Ein Fehler trat beim Hochladen der Datei auf.");
        setTimeout(function() {
            window.location.href = "verkaufsgeraete_intern.php";
        }, 1000);
    </script>';
}
exit;
?>