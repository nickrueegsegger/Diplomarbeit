<?php
session_start();

include "C:/xampp/htdocs/db_connect.php";

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$queryTelefonnummer = "SELECT Telefonnummer FROM Personen WHERE PID = ?";
$paramsTelefonnummer = [$_SESSION['user']['PID']];

$stmtTelefonnummer = sqlsrv_query($conn, $queryTelefonnummer, $paramsTelefonnummer);
$rowTelefonnummer = sqlsrv_fetch_array($stmtTelefonnummer, SQLSRV_FETCH_ASSOC);

if ($rowTelefonnummer) {
    $telefonnummer = $rowTelefonnummer['Telefonnummer'];
} else {
    $telefonnummer = "unbekannt";
}


if (isset($_POST['terminDatum'], $_POST['startZeit'], $_POST['endZeit'], $_POST['mitarbeiter_id'])) {

    $terminDatum = $_POST['terminDatum'];
    $startZeit = $_POST['startZeit'];
    $endZeit = $_POST['endZeit'];
    $mitarbeiter_id = $_POST['mitarbeiter_id'];

    // Datum und Zeit formatieren
    $startDatetime = $terminDatum . " " . $startZeit;
    $endDatetime = $terminDatum . " " . $endZeit;

    $queryMitarbeiter = "SELECT Mvorname, Mnachname FROM BuchbareMitarbeiter WHERE MitarbeiterID = ?";
    $paramsMitarbeiter = [$mitarbeiter_id];

    $stmtMitarbeiter = sqlsrv_query($conn, $queryMitarbeiter, $paramsMitarbeiter);
    $rowMitarbeiter = sqlsrv_fetch_array($stmtMitarbeiter, SQLSRV_FETCH_ASSOC);

    if ($rowMitarbeiter) {
        $mitarbeiterVorname = $rowMitarbeiter['Mvorname'];
        $mitarbeiterNachname = $rowMitarbeiter['Mnachname'];
    } else {
        $mitarbeiterVorname = "unbekannt";
        $mitarbeiterNachname = "unbekannt";
    }

    $startDateTimeObj = DateTime::createFromFormat('Y-m-d H:i', $startDatetime);
    $endDateTimeObj = DateTime::createFromFormat('Y-m-d H:i', $endDatetime);

    function showErrorAndRedirect($message)
    {
        echo "<script>
        alert('$message');
        setTimeout(function() {
            window.location.href = 'mitarbeiterbuchung_extern.php';
        }, 1000);
    </script>";
        exit();
    }

    // Überprüfe, ob der Buchungstag ein Sonntag ist
    if ($startDateTimeObj->format('N') == 7) {
        showErrorAndRedirect("Leider können Sie keinen Beratungstermin an einem Sonnatg buchen. Bitte wählen Sie einen Termin, der innerhalb unserer angegebenen Arbeitszeiten liegt. Vielen Dank für Ihr Verständnis.");
    }

    // Überprüfe Buchungszeiten für Werktage (Montag-Freitag)
    if ($startDateTimeObj->format('N') >= 1 && $startDateTimeObj->format('N') <= 5) {
        if ($startDateTimeObj->format('H:i') < '07:00' || $endDateTimeObj->format('H:i') > '18:00') {
            showErrorAndRedirect("Beratungstermine unter der Woche sind nur von Montag bis Freitag von 07:00 bis 18:00 verfügbar. Vielen Dank für Ihr Verständnis.");
        }
    }

    // Überprüfe Buchungszeiten für Samstag
    if ($startDateTimeObj->format('N') == 6) {
        if ($startDateTimeObj->format('H:i') < '08:00' || $endDateTimeObj->format('H:i') > '14:00') {
            showErrorAndRedirect("Beratungstermine am Samstag sind nur von 08:00 bis 14:00 verfügbar. Vielen Dank für Ihr Verständnis.");
        }
    }

    $query = "INSERT INTO Mitarbeiterbuchungen (Terminbeginn, Terminende, MitarbeiterID, PID) VALUES (?, ?, ?, ?)";
    $params = [$startDatetime, $endDatetime, $mitarbeiter_id, $_SESSION['user']['PID']];


    $result = sqlsrv_query($conn, $query, $params);

    if ($result) {
        // E-Mail-Versand
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
            $mailer->addAddress($_SESSION['user']['Mail'], $_SESSION['user']['Vorname'] . ' ' . $_SESSION['user']['Nachname']);

            $mailer->isHTML(true);
            $mailer->Subject = 'Terminbestätigung';

            $startDateTimeObj = DateTime::createFromFormat('Y-m-d H:i', $startDatetime);
            $endDateTimeObj = DateTime::createFromFormat('Y-m-d H:i', $endDatetime);

            $formattedStartDatetime = $startDateTimeObj->format('d.m.Y H:i');
            $formattedEndDatetime = $endDateTimeObj->format('d.m.Y H:i');

            $mailer->Body = "Guten Tag " . $_SESSION['user']['Vorname'] . " " . $_SESSION['user']['Nachname'] . ", Ihr Termin bei " . $mitarbeiterVorname . " " . $mitarbeiterNachname . " wurde erfolgreich gebucht von $formattedStartDatetime bis $formattedEndDatetime.";

            $mailer->send();



            $mailer->clearAddresses();
            $mailer->setFrom('info@multimedia-shop-langnau.ch', 'Elektro Liechti AG');
            $mailer->addAddress('runi38@gmail.com');
            $mailer->Subject = 'Neuer Beratungstermin!';
            $mailer->Body = $_SESSION['user']['Vorname'] . " " . $_SESSION['user']['Nachname'] . " (Telefonnummer: " . $telefonnummer . ") hat soeben einen neuen Beratungstermin bei " . $mitarbeiterVorname . " " . $mitarbeiterNachname . " gebucht: Vom " . $formattedStartDatetime . " zum " . $formattedEndDatetime . ".";
            $mailer->send();
        } catch (Exception $e) {
            echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
        }

        echo '<script> 
            alert("Termin erfolgreich gebucht!");
            setTimeout(function() {
                window.location.href = "mitarbeiterbuchung_extern.php";
            }, 1000);
        </script>';
    } else {
        echo '<script>
            alert("Fehler bei der Terminbuchung.");
            setTimeout(function() {
                window.location.href = "mietgeraete_extern.php";
            }, 1000);
        </script>';
    }

} else {
    echo "Unzureichende Daten übermittelt!";
}
?>