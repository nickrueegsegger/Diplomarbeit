<?php include 'get_mietgeraete_intern.php'
    ?>

<div class="vermietungsliste">
    <form action="reservierung_bearbeiten.php" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th></th>
                    <th>Reservierungs-ID</th>
                    <th>Mietgeräte-Typ</th>
                    <th>Nachname</th>
                    <th>Vorname</th>
                    <th>Vermietungsbeginn</th>
                    <th>Vermietungsende</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><input type='checkbox' name='selected_reservations[]'
                                value='<?php echo $reservation['VermietungsID']; ?>'></td>
                        <td>
                            <?php echo $reservation['VermietungsID']; ?>
                        </td>
                        <td>
                            <?php echo $reservation['Mietgeraetetyp']; ?>
                        </td>
                        <td>
                            <?php echo $reservation['KundeNachname']; ?>
                        </td>
                        <td>
                            <?php echo $reservation['KundeVorname']; ?>
                        </td>
                        <td>
                            <?php echo $reservation['Vermietungsbeginn']->format('d.m.Y'); ?>
                        </td>
                        <td>
                            <?php echo $reservation['Vermietungsende']->format('d.m.Y'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <input type="submit" name="delete" value="Ausgewählte löschen">
    </form>
</div>
<div class="update-container">
    <div class="datum-update">
        <h3>Reservierung bearbeiten:</h3>
        <form action="reservierung_bearbeiten.php" method="post">
            <div class="form-group">
                <label for="reservierung-id">Reservierung ID:</label>
                <input type="number" name="reservierung_id" id="reservierung-id">
            </div>

            <div class="form-group">
                <label for="start-date">Neuer Beginn:</label>
                <input type="date" name="start_date" id="start-date">
            </div>

            <div class="form-group">
                <label for="end-date">Neues Ende:</label>
                <input type="date" name="end_date" id="end-date">
            </div>

            <input type="submit" name="update" value="Datum aktualisieren" class="submit-btn">
        </form>
    </div>
</div>
</div>