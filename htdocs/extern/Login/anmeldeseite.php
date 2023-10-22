<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">

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
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmelden_registrieren.php">Mein Konto</a>';
                echo '<a href="/extern/Login/logout.php">Ausloggen</a>';
            } else {
                echo '<h3>Sie sind nicht angemeldet.</h3>';
                echo '<a href=/extern/Verkauf/verkaufsgeraete_extern.php>Verkaufsgeräte</a>';
                echo '<a href="/extern/Mietgeraete/mietgeraete_extern.php">Mietgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';

            }
            ?>
        </nav>
    </header>

    <?php
    if (isset($_SESSION['logged_out']) && $_SESSION['logged_out'] === true) {
        echo '<div class="notification" id="logoutNotification">
                Sie wurden erfolgreich ausgeloggt.
              </div>';
        unset($_SESSION['logged_out']);
    }
    ?>

    <!-- Anmeldung Kachel -->
    <div class="kachel">
        <h2>Anmelden</h2>
        <form action="login.php" method="post">
            <label>Email:
                <input type="email" name="email" required>
            </label>
            <label>Passwort:
                <input type="password" name="passwort" required>
            </label>

            <a href="password_reset.php">Passwort vergessen?</a>
            <button type="submit">Anmelden</button>
        </form>
    </div>

    <!-- Registrierung Kachel -->
    <div class="kachel">
        <h2>Registrieren</h2>
        <form action="register.php" method="post">
            <label>Nachname:
                <input type="text" name="nachname" required>
            </label>
            <label>Vorname:
                <input type="text" name="vorname" required>
            </label>
            <label>Telefonnummer:
                <input type="text" name="telefonnummer" placeholder="z.B. 0791234578" pattern="^0\d{9}$"
                    title="Die Telefonnummer muss mit einer 0 beginnen und insgesamt 10 Ziffern haben." required>
            </label>
            <label>Email:
                <input type="email" name="Mail" placeholder="E-Mail" required>
            </label>
            <label>Passwort:
                <input type="password" name="passwort" required>
            </label>
            <button type="submit">Registrieren</button>
        </form>
    </div>

    <script src="anmelden_registrieren.js"></script>
</body>

</html>