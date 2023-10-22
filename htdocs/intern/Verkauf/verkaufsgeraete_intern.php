<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /intern/Login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkaufsgeräte</title>
    <link rel="stylesheet" href="verkaufsgeraete_intern.css">

</head>

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

            <a href="/intern/Mietgeraete/mietgeraete_intern.php">Mietgeräte</a>
            <a href="/intern/Mitarbeiterbuchung/mitarbeiterbuchung_intern.php">Mitarbeiterbuchung</a>
            <a href="/intern/Login/logout.php">Logout</a>
        </nav>
    </header>
    <!-- Gerät ins Sortiment aufnehmen-->
    <div class="kachel">
        <h2>Neues Gerät ins Sortiment aufnehmen</h2>
        <form action="save_device.php" method="post" enctype="multipart/form-data">
            <label>Marke:
                <select name="marke" id="brandSelect">
                </select>
            </label>
            <label>Modell:
                <input type="text" name="modell">
            </label>
            <label>Gerätetyp:
                <select name="geraetebezeichnung" id="typeSelect">
                </select>
            </label>
            <label>Einkaufspreis exkl. MwSt:
                <input type="number" name="einkaufspreis">
            </label>
            <label>Verkaufspreis:
                <input type="number" name="verkaufspreis">
            </label>
            <label> Beschreibungstext:
                <textarea name="beschreibung" placeholder="Geben Sie jeden Punkt in einer neuen Zeile ein."></textarea>
            </label>
            <label>Bild:
                <input type="file" name="bild">
            </label>
            <button type="submit">Speichern</button>
        </form>
    </div>

    <!-- Tabelle Sortiment-->
    <div class="kachel">
        <h2>Sortiment</h2>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Marke<select name="marke" id="brandFilter">
                        </select></th>
                    <th>Modell</th>
                    <th>Gerätetyp</th>
                    <th>Einkaufspreis exkl. MwSt</th>
                    <th>Verkaufspreis</th>
                    <th>Lagerbestand</th>
                </tr>
            </thead>
            <tbody id="availableDeviceTableBody">
            </tbody>
        </table>
        <button id="deleteSortimentButton">Ausgewählte Geräte löschen</button>
    </div>
    <!-- Neues Lagergerät erfassen-->
    <div class="kachel">
        <h2>Neues Lagergerät erfassen</h2>
        <form id="lagergeraetForm">
            <label>Gerät auswählen:
                <select name="sortimentId" id="sortimentDropdown">

                </select>
            </label>
            <label>Seriennummer:
                <input type="text" name="seriennummer" required>
            </label>
            <button type="submit">Gerät ins Lager aufnehmen</button>
        </form>
    </div>

    <!-- Tabelle für Lagergeräte -->
    <div class="kachel">
        <h2>Lagergeräte</h2>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Marke</th>
                    <th>Modell</th>
                    <th>Gerätetyp</th>
                    <th>Seriennummer</th>
                    <th>Verkaufspreis</th>
                    <th>Verkauft</th>
                </tr>
            </thead>
            <tbody id="lagerGeraeteList">
            </tbody>
        </table>
        <button id="updateStatusButton">Als verkauft markieren</button>
        <button id="deleteLagerButton">Ausgewählte Geräte löschen</button>
    </div>


    <!-- Tabelle für verkaufte Geräte -->
    <div class="kachel">
        <h2>Verkaufte Geräte</h2>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Marke</th>
                    <th>Typ</th>
                    <th>Gerätetyp</th>
                    <th>Seriennummer</th>
                    <th>Verkaufspreis</th>
                    <th>Verkauft</th>
                </tr>
            </thead>
            <tbody id="soldDeviceTableBody">

            </tbody>
        </table>
        <button id="deleteVerkauftButton">Ausgewählte Geräte löschen</button>
    </div>
    <script src="verkaufsgeraete_intern.js"></script>
</body>

</html>