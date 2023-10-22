<?php
session_start();
include 'C:\xampp\htdocs\db_connect.php';

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
    $startDatum = $_POST['startDatum'];
    $endDatum = $_POST['endDatum'];
    $mietgeraet_id = $_POST['mietgeraet_id'];
    $pid = $_SESSION['user']['PID'];

    $startDatumObj = DateTime::createFromFormat('Y-m-d', $startDatum);
    $endDatumObj = DateTime::createFromFormat('Y-m-d', $endDatum);

    $formattedStartDatum = $startDatumObj->format('d.m.Y');
    $formattedEndDatum = $endDatumObj->format('d.m.Y');


    // Prüfen, ob das Gerät in diesem Zeitraum bereits reserviert ist
    $query = "SELECT * FROM Vermietung WHERE MietgeraetID = ? AND ((Vermietungsbeginn BETWEEN ? AND ?) OR (Vermietungsende BETWEEN ? AND ?) OR (Vermietungsbeginn <= ? AND Vermietungsende >= ?))";
    $params = array($mietgeraet_id, $startDatum, $endDatum, $startDatum, $endDatum, $startDatum, $endDatum);

    $stmt = sqlsrv_query($conn, $query, $params);

    if (sqlsrv_has_rows($stmt)) {
        echo '<script>
        alert("Dieses Gerät ist im gewählten Zeitraum bereits reserviert.");
        setTimeout(function() {
            window.location.href = "mietgeraete_extern.php";
        }, 1000);
      </script>';
    } else {
        $query = "INSERT INTO Vermietung (Vermietungsbeginn, Vermietungsende, MietgeraetID, PID) VALUES (?, ?, ?, ?)";
        $params = array($startDatum, $endDatum, $mietgeraet_id, $pid);

        $stmt = sqlsrv_query($conn, $query, $params);
        if ($stmt) {



            $query = "SELECT Nachname, Vorname, Mail, Telefonnummer FROM Personen WHERE PID = ?";
            $params = array($pid);
            $stmt = sqlsrv_query($conn, $query, $params);
            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $nachname = $row['Nachname'];
                $vorname = $row['Vorname'];
                $telefonnummer = $row['Telefonnummer'];
                $mail = $row['Mail'];


                $query = "SELECT Mietgeraetetyp FROM Mietgeraete WHERE MietgeraetID = ?";
                $params = array($mietgeraet_id);
                $stmt = sqlsrv_query($conn, $query, $params);
                if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $geraetetyp = $row['Mietgeraetetyp'];

                    // E-Mail senden
                    $mailer = new PHPMailer(true);
                    $mailer->CharSet = 'UTF-8';
                    try {
                        $mailer->isSMTP();
                        $mailer->Host = 'asmtp.mail.hostpoint.ch';
                        $mailer->SMTPAuth = true;
                        $mailer->Username = 'info@multimedia-shop-langnau.ch';
                        $mailer->Password = 'MoeckliRCF1300!';
                        $mailer->Port = 25;

                        $mailer->setFrom('info@multimedia-shop-langnau.ch', 'Elektro Liechti AG');
                        $mailer->addAddress($mail, $vorname . ' ' . $nachname);
                        $mailer->isHTML(true);
                        $mailer->Subject = 'Reservierungsbestätigung';
                        $mailer->Body = "Guten Tag " . $vorname . " " . $nachname . ", vielen Dank für die Reservierung des folgenden Mietgeräts: " . $geraetetyp . ". Sie haben das Gerät vom " . $formattedStartDatum . " bis zum " . $formattedEndDatum . " reserviert.";
                        $mailer->send();


                        $mailer->clearAddresses();
                        $mailer->setFrom('info@multimedia-shop-langnau.ch', 'Elektro Liechti AG');
                        $mailer->addAddress('runi38@gmail.com');
                        $mailer->Subject = 'Neue Gerätereservierung!';
                        $mailer->Body = "Folgender Kunde hat soeben ein Gerät reserviert: $vorname $nachname (Tel: $telefonnummer). Mietgerät: $geraetetyp, Vermietet vom $formattedStartDatum bis zum $formattedEndDatum";
                        $mailer->send();

                    } catch (Exception $e) {
                        echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
                    }
                }
            }

            echo '<script> 
            alert("Reservierung erfolgreich!");
            setTimeout(function() {
                window.location.href = "mietgeraete_extern.php";
            }, 1000);
          </script>';
        } else {
            echo '<script>
            alert("Fehler bei der Reservierung.");
            setTimeout(function() {
                window.location.href = "mietgeraete_extern.php";
            }, 1000);
          </script>';
        }
    }
} else {
    echo "Ungültige Anfrage oder Benutzer nicht eingeloggt.";
}
?>