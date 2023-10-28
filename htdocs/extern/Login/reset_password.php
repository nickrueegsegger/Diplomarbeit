<?php
include 'C:\xampp\htdocs\db_connect.php';

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['reset_email'];

    $query = "SELECT * FROM Personen WHERE Mail = ?";
    $params = array($mail);

    $stmt = sqlsrv_query($conn, $query, $params);
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($user) {
        // Zufälliges temporäres Passwort generieren
        $temp_pass = bin2hex(random_bytes(4));

        // Update Passwort in der Datenbank
        $updateQuery = "UPDATE Personen SET Passwort = ? WHERE Mail = ?";
        $updateParams = array($temp_pass, $mail);
        sqlsrv_query($conn, $updateQuery, $updateParams);


        $to = $mail;
        $subject = "Ihr temporäres Passwort";
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
            $mailer->addAddress($to);
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body = "Ihr temporäres Passwort ist: " . $temp_pass . ". Bitte ändern Sie es sofort nach dem Anmelden.";
            $mailer->send();

            echo "Ein temporäres Passwort wurde an Ihre E-Mail-Adresse gesendet. Sie werden in 3 Sekunden weitergeleitet.";
            echo "<script>
            setTimeout(function() {
                window.location.href = 'anmeldeseite.php'; // Ändern Sie dies in den tatsächlichen Pfad Ihrer Anmeldeseite
            }, 3000); 
          </script>";

        } catch (Exception $e) {
            echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
        }
    } else {
        echo "Es gibt kein Konto mit dieser E-Mail-Adresse.";
    }


}
?>