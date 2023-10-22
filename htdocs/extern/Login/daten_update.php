<?php
session_start();
include 'C:\xampp\htdocs\db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: anmelden_registrieren.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nachname = $_POST['nachname'];
    $vorname = $_POST['vorname'];
    $mail = $_POST['Mail'];
    $passwort = $_POST['passwort'];

    if (empty($passwort)) {
        $query = "UPDATE Personen SET Nachname=?, Vorname=?, Mail=? WHERE Mail=?";
        $params = array($nachname, $vorname, $mail, $_SESSION['user']['Mail']);
    } else {
        $query = "UPDATE Personen SET Nachname=?, Vorname=?, Mail=?, Passwort=? WHERE Mail=?";
        $params = array($nachname, $vorname, $mail, $passwort, $_SESSION['user']['Mail']);
    }

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {

        $_SESSION['user']['Nachname'] = $nachname;
        $_SESSION['user']['Vorname'] = $vorname;
        $_SESSION['user']['Mail'] = $mail;
        header('Location: anmelden_registrieren.php');
        exit();
    }
}
?>