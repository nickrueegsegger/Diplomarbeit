<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkaufsgeräte</title>
    <link rel="stylesheet" href="verkaufsgeraete_extern.css">
    <script src="verkaufsgeraete_extern.js"></script>
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
        <div>

        </div>
        <nav>
            <?php
            if (isset($_SESSION['user'])) {
                echo "<h2>Willkommen, " . $_SESSION['user']['Vorname'] . " " . $_SESSION['user']['Nachname'] . "!</h2>";
                echo '<a href="/extern/Mietgeraete/mietgeraete_extern.php">Mietgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmelden_registrieren.php">Mein Konto</a>';
                echo '<a href="/extern/Login/logout.php">Ausloggen</a>';
            } else {
                echo '<h3>Sie sind nicht angemeldet.</h3>';
                echo '<a href="/extern/Mietgeraete/mietgeraete_extern.php">Mietgeräte</a>';
                echo '<a href="/extern/Mitarbeiterbuchung/mitarbeiterbuchung_extern.php">Mitarbeiterbuchung</a>';
                echo '<a href="/extern/Login/anmeldeseite.php">Registrieren & Anmelden</a>';
            }
            ?>
        </nav>

    </header>

    <main>
        <h1 class="titel">Unser Sortiment:</h1>
        <div id="products">
            <!-- Dieser Bereich wird  mit Produkten gefüllt -->
        </div>


</body>

</html>