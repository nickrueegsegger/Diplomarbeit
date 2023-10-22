<?php

include 'C:\xampp\htdocs\db_connect.php';

$benutzername = $_POST['benutzername'];
$login_passwort = $_POST['login_passwort'];

$query = "INSERT INTO Login (Benutzername, LoginPasswort) VALUES (?, ?)";
$params = array($benutzername, $login_passwort);

$result = sqlsrv_query($conn, $query, $params);

if ($result) {
  // Weiterleitung zur Seite mit den Verkaufsgeräten
  header("Location: /intern/Verkauf/verkaufsgeraete_intern.php");
} else {
  die(print_r(sqlsrv_errors(), true));
}
?>