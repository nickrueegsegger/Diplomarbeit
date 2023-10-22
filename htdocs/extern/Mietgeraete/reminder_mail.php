<?php
include 'C:\xampp\htdocs\db_connect.php';

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$now = new DateTime();

//24 Stunden addieren, um den Zeitpunkt 24h vor dem Termin festzustellen
$reminderTime = $now->add(new DateInterval('PT24H'));


$reminderDate = $reminderTime->format('Y-m-d');


$query = "SELECT * FROM Vermietung JOIN Personen ON Vermietung.PID = Personen.PID WHERE Vermietungsbeginn = ?";
$params = array($reminderDate);

$stmt = sqlsrv_query($conn, $query, $params);

while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $vorname = $row['Vorname'];
    $nachname = $row['Nachname'];
    $email = $row['Mail'];

    if ($row['Vermietungsbeginn'] instanceof DateTime) {
        $startDatumObj = $row['Vermietungsbeginn'];
    } else {
        $startDatumObj = DateTime::createFromFormat('Y-m-d', $row['Vermietungsbeginn']);
    }
    
    if ($row['Vermietungsende'] instanceof DateTime) {
        $endDatumObj = $row['Vermietungsende'];
    } else {
        $endDatumObj = DateTime::createFromFormat('Y-m-d', $row['Vermietungsende']);
    }
    
    $formattedStartDatum = $startDatumObj->format('d.m.Y');
    $formattedEndDatum = $endDatumObj->format('d.m.Y');
    

   $query = "SELECT Mietgeraetetyp FROM Mietgeraete WHERE MietgeraetID = ?";
   $mietgeraet_id = $row['MietgeraetID'];
   $params = array($mietgeraet_id);
   $stmt2 = sqlsrv_query($conn, $query, $params);

   if ($row = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
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
        $mailer->addAddress($email, $vorname . ' ' . $nachname);
        $mailer->isHTML(true);
        $mailer->Subject = 'Reservierungsbestätigung';
        $mailer->Body = "Guten Tag " . $vorname . " " . $nachname . ", Sie können folgendes Mietgerät Morgen abholen: " . $geraetetyp . ". Sie haben das Gerät vom " . $formattedStartDatum . " bis zum " . $formattedEndDatum . " reserviert. Vielen Dank!";
        $mailer->send();

       } catch (Exception $e) {
           echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
       }
   }
}
?>