<?php
include 'get_mietgeraete_intern.php';
?>

<?php foreach ($devicesWithRentals as $device): ?>
    <div class="flex-item">
        <div class="text-container"> <!-- Text Container -->
            <h2>
                <?php echo $device["Mietgeraetetyp"]; ?>
            </h2>
            <p>Marke:
                <?php echo $device["MarkenName"]; ?>
            </p>
            <p>Mietpreis pro Tag:
                <?php echo $device["MietpreisproTag"]; ?>CHF
            </p>
        </div>

        <div class="calendar-container"> <!-- Kalender Container -->
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
                                'end' => $rental['Vermietungsende']->format('Y-m-d')
                            ];
                        }, $device['rentals'])); ?>
                    });
                    calendar.render();
                });
            </script>
        </div>

    </div>
<?php endforeach; ?>