<?php
session_start();

$userIsLoggedIn = false;
if (isset($_SESSION['userid'])) {
    $userIsLoggedIn = true;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mietgeräte</title>
    <link rel="stylesheet" href="mietgeraete_extern.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="https://elektro-liechti.ch/">
                <img src="/Logos/logoelektroliechti.png" alt="Logo 1">

            </a>
        </div>
        <div class="logo">
            <a href="https://multimedia-langnau.ch/">
                <img src="/Logos/LOGO_MULTIMEDIA.png" alt="Logo 2">

            </a>
        </div>
        <nav>
            <?php
            if (isset($_SESSION['user'])) {
                echo "<h2>Willkommen, " . $_SESSION['user']['Vorname'] . " " . $_SESSION['user']['Nachname'] . "!</h2>";
                echo '<a href=/extern/Verkauf/verkaufsgeraete_extern.php>Verkaufsgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmelden_registrieren.php">Mein Konto</a>';
                echo '<a href="/extern/Login/logout.php">Ausloggen</a>';
            } else {
                echo '<h3>Sie sind nicht angemeldet.</h3>';
                echo '<a href=/extern/Verkauf/verkaufsgeraete_extern.php>Verkaufsgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmeldeseite.php">Registrieren & Anmelden</a>';
            }
            ?>

        </nav>
    </header>
    <div class="kachel">
        <h1>Unsere Mietgeräte:</h1>
        <h4>Hier erhalten Sie eine Übersicht unserer Mietgeräte. Wir erweitern unser Angebot laufend. Wenn Sie sich
            registrieren und Anmelden, können Sie ein Gerät reservieren.</h4>
        <?php include 'display_mietgeraete.php'; ?>
    </div>
</body>

</html>