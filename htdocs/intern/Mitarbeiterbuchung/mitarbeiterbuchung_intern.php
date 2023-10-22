<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /intern/Login/login.php");
    exit;
}

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
    <link rel="stylesheet" href="mitarbeiterbuchung_intern.css">
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
            <img src="/Logos/logoelektroliechti.png" alt="Logo 1">
        </div>
        <div class="logo">
            <img src="/Logos/LOGO_MULTIMEDIA.png" alt="Logo 2">
        </div>
        <nav>
            <h2>Willkommen
                <?php echo $_SESSION['user']['Benutzername'] ?>!
            </h2>
            <a href="/intern/Verkauf/verkaufsgeraete_intern.php">Verkaufsgeräte</a>
            <a href="/intern/Mietgeraete/mietgeraete_intern.php">Mietgeräte</a>
            <a href="/intern/Login/logout.php">Logout</a>

        </nav>
    </header>

    <?php include 'get_mitarbeiter_termine.php'; ?>

    <div class="terminliste">
        <form action="termin_bearbeiten.php" method="post">
            <table border="1">
                <h3>Terminliste:</h3>
                <thead>
                    <tr>
                        <th></th>
                        <th>Termin-ID</th>
                        <th>Mitarbeiter</th>
                        <th>Kunde</th>
                        <th>Terminbeginn</th>
                        <th>Terminende</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($termine as $termin): ?>
                        <tr>
                            <td><input type='checkbox' name='selected_termine[]'
                                    value='<?php echo $termin['MitarbeiterbuchungsID']; ?>'></td>
                            <td>
                                <?php echo $termin['MitarbeiterbuchungsID']; ?>
                            </td>
                            <td>
                                <?php echo $termin['Mvorname'] . " " . $termin['Mnachname']; ?>
                            </td>
                            <td>
                                <?php echo $termin['KundeVorname'] . " " . $termin['KundeNachname']; ?>
                            </td>
                            <td>
                                <?php echo $termin['Terminbeginn']->format('d.m.Y H:i'); ?>
                            </td>
                            <td>
                                <?php echo $termin['Terminende']->format('d.m.Y H:i'); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <input type="submit" name="delete" value="Ausgewählte löschen">
        </form>
    </div>

    <div class="datum-update">

        <form action="termin_bearbeiten.php" method="post">
            <div class="form-group">
                <h3>Termin bearbeiten:</h3>
                <label for="termin-id">Termin ID:</label>
                <input type="number" name="termin_id" id="termin-id">
            </div>

            <div class="form-group">
                <label for="start-date">Neuer Beginn:</label>
                <input type="date" name="start_date" id="start-date">
                <input type="time" name="start_time" id="start-time">
            </div>

            <div class="form-group">
                <label for="end-date">Neues Ende:</label>
                <input type="date" name="end_date" id="end-date">
                <input type="time" name="end_time" id="end-time">
            </div>

            <br>
            <input type="submit" name="update" value="Datum aktualisieren" class="submit-btn">
        </form>
    </div>


    <div class="mitarbeiter-section">
        <?php foreach ($mitarbeiter as $m): ?>

            <?php
            // Die Beschreibung an jedem Zeilenumbruch auftrennen
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
            </div>

        <?php endforeach; ?>
    </div>


    <form action="add_mitarbeiter.php" method="post" enctype="multipart/form-data">
        <h3>Neuer Mitabrbeiter hinzufügen<h3>
                Vorname: <input type="text" name="vorname"><br>
                Nachname: <input type="text" name="nachname"><br>
                Bild: <input type="file" name="bild"><br>
                Beschreibung:
                <textarea name="beschreibung" placeholder="Geben Sie jeden Punkt in einer neuen Zeile ein."></textarea>
                <br>
                <input type="submit" name="submit" value="Mitarbeiter hinzufügen">
    </form>
</body>

</html>