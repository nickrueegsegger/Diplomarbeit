<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: anmeldeseite.php");
    exit();
}
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

    <body>
        <h3>Hier können Sie ihre Daten bearbeiten:</h3>
        <div class="kachel">
            <form action="daten_update.php" method="post">
                <label>Nachname:
                    <input type="text" name="nachname" value="<?php echo $_SESSION['user']['Nachname']; ?>" required>
                </label>
                <label>Vorname:
                    <input type="text" name="vorname" value="<?php echo $_SESSION['user']['Vorname']; ?>" required>
                </label>
                <label>Email:
                    <input type="email" name="Mail" value="<?php echo $_SESSION['user']['Mail']; ?>" required>
                </label>
                <label>Neues Passwort (lassen Sie es leer, wenn Sie es nicht ändern möchten):
                    <input type="password" name="passwort">
                </label>
                <button type="submit">Daten aktualisieren</button>
            </form>
        </div>
    </body>

</html>