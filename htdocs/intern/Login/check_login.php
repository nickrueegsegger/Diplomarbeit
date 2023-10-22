<?php
session_start(); //Session wird gestartet, damit man angemeldet bleibt
include "C:/xampp/htdocs/db_connect.php";

$benutzername = $_POST['benutzername'];
$passwort = $_POST['passwort'];

$query = "SELECT * FROM Login WHERE Benutzername = ? AND LoginPasswort = ?";
$params = array($benutzername, $passwort);
$result = sqlsrv_query($conn, $query, $params);

if ($row = sqlsrv_fetch_array($result)) {
    $_SESSION['loggedin'] = true;
    $_SESSION['user'] = array(
        'Benutzername' => $row['Benutzername']
    );
    header("Location: /intern/Verkauf/verkaufsgeraete_intern.php");
    exit;
} else {

    echo '<script>
    alert("Falscher Benutzername oder Passwort!");
    setTimeout(function() {
        window.location.href = "login.php";
    }, 1000);
</script>';
}
?>