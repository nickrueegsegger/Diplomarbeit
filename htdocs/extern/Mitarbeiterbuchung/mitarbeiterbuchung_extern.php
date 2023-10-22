<?php
session_start();
include "C:/xampp/htdocs/db_connect.php";

$query = "SELECT * FROM BuchbareMitarbeiter";
$result = sqlsrv_query($conn, $query);
$mitarbeiter = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $mitarbeiter[] = $row;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitarbeiterbuchung</title>
    <link rel="stylesheet" href="mitarbeiterbuchung_extern.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mitarbeiterIDs = <?php echo json_encode(array_column($mitarbeiter, 'MitarbeiterID')); ?>;

        mitarbeiterIDs.forEach(function (mitarbeiterID) {
            var calendarEl = document.getElementById('calendar-' + mitarbeiterID);
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'de',
                initialView: 'dayGridMonth',
                events: 'fetch_events.php?mitarbeiterID=' + mitarbeiterID

            });
            calendar.render();
        });
    });
</script>

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
                echo '<a href="/extern/Login/anmeldeseite.php">Registrieren & Anmelden</a>';
            }
            ?>
        </nav>

    </header>

    <?php include 'get_mitarbeiter_termine.php'; ?>

    <h2 class="titel">Hier können Sie einen Beratungstermin mit einem unserer Mitarbeiter buchen. Für den Termin
        besuchen Sie uns bitte in unserem Verkaufsladen an der Bahnhofstrasse 15 in Langnau.</h2>

    <div class="mitarbeiter-section">
        <?php foreach ($mitarbeiter as $m): ?>

            <?php
            $beschreibungPunkte = explode("\n", $m['Beschreibung']);
            ?>

            <div class="mitarbeiter">
                <h3>
                    <?php echo $m['Mvorname'] . " " . $m['Mnachname']; ?>
                </h3>
                <img src="<?php echo $m['BildpfadMitarbeiter']; ?>" alt="<?php echo $m['Mvorname']; ?>">
                <ul>
                    <?php foreach ($beschreibungPunkte as $punkt): ?>
                        <?php if (trim($punkt) != ""): // Ignoriere leere Zeilen ?>
                            <li>
                                <?php echo trim($punkt); ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <div id="calendar-<?php echo $m['MitarbeiterID']; ?>"></div>

                <?php if (isset($_SESSION['user'])): ?>
                    <form method="post" action="buchung_mitarbeiter.php">
                        <label for="terminDatum">Termin Datum:</label>
                        <input type="date" name="terminDatum" id="terminDatum" required>
                        <label for="startZeit">Startzeit:</label>
                        <input type="time" name="startZeit" id="startZeit" required>
                        <label for="endZeit">Endzeit:</label>
                        <input type="time" name="endZeit" id="endZeit" required>
                        <input type="hidden" name="mitarbeiter_id" value="<?php echo $m['MitarbeiterID']; ?>">
                        <br>
                        <input type="submit" value="Termin buchen">
                    </form>
                <?php else: ?>
                    <p>Um einen Termin zu buchen, melden Sie sich bitte an.</p>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>
    </div>



</body>

</html>