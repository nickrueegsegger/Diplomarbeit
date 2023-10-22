<?php
include 'C:\xampp\htdocs\db_connect.php';

$markenID = $_POST['marke'];
$typ = $_POST['typ'];
$mietpreis = $_POST['mietpreis'];

// Upload-Ordner-Pfad
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/intern/Mietgeraete/uploads/';
$uploadFile = $uploadDir . basename($_FILES['bild']['name']);


$relativePath = '/intern/Mietgeraete/uploads/' . basename($_FILES['bild']['name']);

if (move_uploaded_file($_FILES['bild']['tmp_name'], $uploadFile)) {
    $query = "INSERT INTO Mietgeraete (MarkenID, Mietgeraetetyp, MietpreisproTag, Bildpfad) VALUES (?, ?, ?, ?)";
    $params = array($markenID, $typ, $mietpreis, $relativePath);

    $result = sqlsrv_query($conn, $query, $params);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo '<script>
        alert("Die Datei und Daten wurden erfolgreich hochgeladen");
        setTimeout(function() {
            window.location.href = "mietgeraete_intern.php";
        }, 1000);
    </script>';
} else {
    echo '<script>
        alert("Ein Fehler trat beim Hochladen der Datei auf.");
        setTimeout(function() {
            window.location.href = "mietgeraete_intern.php";
        }, 1000);
    </script>';
}
