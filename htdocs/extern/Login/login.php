<?php
include 'C:\xampp\htdocs\db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['email'];
    $passwort = $_POST['passwort'];

    $query = "SELECT * FROM Personen WHERE Mail = ? AND Passwort = ?";
    $params = array($mail, $passwort);

    $stmt = sqlsrv_query($conn, $query, $params);
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;


        echo '<script>
                alert("Erfolgreich eingeloggt");
                setTimeout(function() {
                    window.location.href = "/extern/Verkauf/verkaufsgeraete_extern.php";
                }, 1000);
              </script>';
    } else {
        echo "Fehler bei der Anmeldung. Überprüfen Sie E-Mail und Passwort.";
    }
}
?>