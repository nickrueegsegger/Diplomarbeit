<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Anmelden / Registrieren</title>
        <link rel="stylesheet" href="anmelden_registrieren.css">

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
                echo '<a href="/extern/Mietgeraete/mietgeraete_extern.php">Mietgeräte</a>';
                echo '<a href="/extern/Login/anmelden_registrieren.php">Mein Konto</a>';
                echo '<a href="/extern/Login/logout.php">Ausloggen</a>';
            } else {
                echo '<h3>Sie sind nicht angemeldet.</h3>';
                echo '<a href=/extern/Verkauf/verkaufsgeraete_extern.php>Verkaufsgeräte</a>';
                echo '<a href="/extern/Mietgeraete/mietgeraete_extern.php">Mietgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmeldeseite.php">Registrieren & Anmelden</a>';
            }
            ?>
        </nav>
    </header>

    <div class="kachel">
        <h2>Passwort zurücksetzen</h2>
        <form action="reset_password.php" method="post">
            <label>Email:
                <input type="email" name="reset_email" required>
            </label>
            <button type="submit">Neues Passwort anfordern</button>
        </form>
    </div>
</body>

</html>