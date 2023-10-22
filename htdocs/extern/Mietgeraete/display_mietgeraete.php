<?php
include 'get_mietgeraete.php';
?>

<div class="flex-container"> <!-- Flex Container -->
    <?php foreach ($devicesWithRentals as $device): ?>
        <div class="flex-item">
            <div class="text-container"> <!--Text Container -->
                <h2>
                    <?php echo $device["Mietgeraetetyp"]; ?>
                </h2>
                <p>Marke:
                    <?php echo $device["MarkenName"]; ?>
                </p>
                <p>Mietpreis pro Tag:
                    <?php echo $device["MietpreisproTag"]; ?> CHF
                </p>
            </div>

            <div class="bilder-extern">
                <?php if (!empty($device["Bildpfad"])): ?>
                    <img src="<?php echo $device["Bildpfad"]; ?>" alt="Bild von <?php echo $device["Mietgeraetetyp"]; ?>">
                <?php endif; ?>
            </div>


            <div class="calendar-container"> <!--Kalender Container -->
                <div id="calendar-<?php echo $device["MietgeraetID"]; ?>"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var calendarEl = document.getElementById('calendar-<?php echo $device["MietgeraetID"]; ?>');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            locale: 'de',
                            initialView: 'dayGridMonth',
                            events: <?php echo json_encode(array_map(function ($rental) {
                                return [
                                    'title' => 'Vermietung',
                                    'start' => $rental['Vermietungsbeginn']->format('Y-m-d'),
                                    'end' => (clone $rental['Vermietungsende'])->modify('+1 day')->format('Y-m-d')
                                ];
                            }, $device['rentals'])); ?>
                        });

                        calendar.render();
                    });
                </script>
            </div>


            <?php if (isset($_SESSION['user'])): ?>
                <form method="post" action="reserve.php">
                    <label for="startDatum">Startdatum:</label>
                    <input type="date" name="startDatum" id="startDatum" required>

                    <label for="endDatum">Enddatum:</label>
                    <input type="date" name="endDatum" id="endDatum" required>

                    <input type="hidden" name="mietgeraet_id" value="<?php echo $device['MietgeraetID']; ?>">
                    <br>
                    <br>
                    <input type="submit" value="Reservieren">
                </form>
            <?php else: ?>
                <p>Wenn Sie ein Gerät reservieren möchten, melden Sie sich an.</p>
            <?php endif; ?>
            <br>
        </div>
    <?php endforeach; ?>
</div>