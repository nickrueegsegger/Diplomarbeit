<?php
include 'C:\xampp\htdocs\db_connect.php';

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$now = new DateTime();

//24 Stunden addieren, um den zeitpunkt 24h vor dem Termin festzustellen
$reminderTime = $now->add(new DateInterval('PT24H'));


$reminderDatetime = $reminderTime->format('Y-m-d H:i:s');

$query = "SELECT * FROM Mitarbeiterbuchungen JOIN Personen ON Mitarbeiterbuchungen.PID = Personen.PID WHERE Terminbeginn = ?";
$params = array($reminderDatetime);

$stmt = sqlsrv_query($conn, $query, $params);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $vorname = $row['Vorname'];
    $nachname = $row['Nachname'];
    $email = $row['Mail'];
    $mitarbeiterID = $row['MitarbeiterID'];
    $queryMitarbeiter = "SELECT Mvorname, Mnachname FROM BuchbareMitarbeiter WHERE MitarbeiterID = ?";
    $paramsMitarbeiter = array($mitarbeiterID);
    $stmtMitarbeiter = sqlsrv_query($conn, $queryMitarbeiter, $paramsMitarbeiter);
    $rowMitarbeiter = sqlsrv_fetch_array($stmtMitarbeiter, SQLSRV_FETCH_ASSOC);
    $mitarbeiterVorname = $rowMitarbeiter['Mvorname'];
    $mitarbeiterNachname = $rowMitarbeiter['Mnachname'];

    // E-Mail senden
    $mailer = new PHPMailer(true);
    $mailer->CharSet = 'UTF-8';
    try {
        $mailer->isSMTP();
        $mailer->Host = 'asmtp.mail.hostpoint.ch';
        $mailer->SMTPAuth = true;
        $mailer->Username = '***';
        $mailer->Password = '***';
        $mailer->Port = 25;

        $mailer->setFrom('***', 'Elektro Liechti AG');
        $mailer->addAddress($email, $vorname . ' ' . $nachname);
        $mailer->isHTML(true);
        $mailer->Subject = 'Erinnerung an Ihren Beratungstermin';
        $mailer->Body = "Guten Tag " . $vorname . " " . $nachname . ", wir möchten Sie daran erinnern, dass Sie morgen einen Beratungstermin bei " . $mitarbeiterVorname . " " . $mitarbeiterNachname . " haben. Wir freuen uns auf Ihren Besuch!";
        $mailer->send();

    } catch (Exception $e) {
        echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
    }
}
?>