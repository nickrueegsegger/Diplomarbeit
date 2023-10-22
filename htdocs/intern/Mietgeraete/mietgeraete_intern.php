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
    <title>Mietgeräte</title>
    <link rel="stylesheet" href="mietgeraete_intern.css">
    <script src="mietgeraete_intern.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
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

            <a href="/intern/Verkauf/verkaufsgeraete_intern.php">Verkaufsgeräte</a>
            <a href="/intern/Mitarbeiterbuchung/mitarbeiterbuchung_intern.php">Mitarbeiterbuchung</a>
            <a href="/intern/Login/logout.php">Logout</a>

        </nav>

    </header>

    <div class="kachel">
        <h2>Neues Mietgerät erfassen</h2>
        <form action="save_mietgeraet.php" method="post" enctype="multipart/form-data">

            <label>Marke:
                <select name="marke" id="brandSelect">
                </select>
            </label>
            <label>Typ:
                <input type="text" name="typ">
            </label>
            <label>Mietpreis pro Tag:
                <input type="number" name="mietpreis">
            </label>
            <label>Bild:
                <input type="file" name="bild">
            </label>

            <button type="submit">Speichern</button>
        </form>
    </div>
    <div class="kachel">
        <h2>Reservierungsliste</h2>
        <div class="flex-container">
            <?php include 'reservationsliste.php'; ?>
        </div>
    </div>
    <h2>Alle Mietgeräte</h2>
    <div class="kachel">
        <div class="flex-container">

            <?php include 'display_mietgeraete_intern.php'; ?>
        </div>
    </div>
</body>

</html>