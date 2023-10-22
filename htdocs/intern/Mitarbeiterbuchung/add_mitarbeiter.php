<?php

include "C:/xampp/htdocs/db_connect.php";

sqlsrv_query($conn, "SET NAMES 'UTF8'");
sqlsrv_query($conn, "SET CHARACTER SET UTF8");

if (isset($_POST['submit'])) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $beschreibung = $_POST['beschreibung'];

    if ($_FILES["bild"]["error"] !== UPLOAD_ERR_OK) {
        die("Datei-Upload-Fehler: " . $_FILES["bild"]["error"]);
    }

    // Bild hochladen
    $root_path = $_SERVER['DOCUMENT_ROOT'];
    $upload_dir = $root_path . "/intern/Mitarbeiterbuchung/uploads/";

    if (!is_dir($upload_dir)) {
        die("$upload_dir existiert nicht.");
    }

    $uploaded_file = $upload_dir . basename($_FILES["bild"]["name"]);

    if (!move_uploaded_file($_FILES["bild"]["tmp_name"], $uploaded_file)) {
        die("Fehler beim Verschieben der hochgeladenen Datei.");
    }

    // Mitarbeiter in DB speichern
    $relative_path_for_db = "/intern/Mitarbeiterbuchung/uploads/" . basename($_FILES["bild"]["name"]);
    $query = "INSERT INTO BuchbareMitarbeiter (Mnachname, Mvorname, BildpfadMitarbeiter, Beschreibung) VALUES (?, ?, ?, ?)";
    $params = array($nachname, $vorname, $relative_path_for_db, $beschreibung);

    $result = sqlsrv_query($conn, $query, $params);

    if (!$result) {
        die(print_r(sqlsrv_errors(), true));
    }

    header('Location: mitarbeiterbuchung_intern.php');
}
?>