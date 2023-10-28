<?php
session_start();
include 'C:\xampp\htdocs\db_connect.php';

require 'C:\xampp\htdocs\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\SMTP.php';
require 'C:\xampp\htdocs\PHPMailer-master\src\Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nachname = $_POST['nachname'];
    $vorname = $_POST['vorname'];
    $telefonnummer = $_POST['telefonnummer'];
    $mail = $_POST['Mail'];
    $passwort = $_POST['passwort'];

    $query = "INSERT INTO Personen (Nachname, Vorname,Telefonnummer, Mail, Passwort) VALUES (?, ?, ?, ?, ?)";
    $params = array($nachname, $vorname, $telefonnummer, $mail, $passwort);

    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {

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
            $mailer->addAddress($_POST['Mail'], $vorname . ' ' . $nachname);


            $mailer->isHTML(true);
            $mailer->Subject = 'Vielen Dank für Ihre Registrierung!';
            $mailer->Body = "Guten Tag $vorname $nachname, vielen Dank für Ihre Registrierung! Ihr Benutzername lautet: $mail";
            $mailer->send();

            $mailer->clearAddresses();
            $mailer->setFrom('***', 'Elektro Liechti AG');
            $mailer->addAddress('***');
            $mailer->Subject = 'Neue Kundenregistrierung!';
            $mailer->Body = "Folgender Kunde hat sich soeben registriert: $vorname $nachname";
            $mailer->send();


        } catch (Exception $e) {
            echo "E-Mail konnte nicht gesendet werden. Fehler: {$mailer->ErrorInfo}";
        }

        $_SESSION['message'] = "Die Registrierung war erfolgreich, Sie können sich nun anmelden.";
        header('Location: redirect_with_message.php');
        exit();
    }
}
?>



