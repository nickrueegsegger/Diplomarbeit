<?php
include 'C:\xampp\htdocs\db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        foreach ($_POST['selected_termine'] as $id) {
            $sql = "DELETE FROM Mitarbeiterbuchungen WHERE MitarbeiterbuchungsID = ?";
            $params = array($id);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        header('Location: mitarbeiterbuchung_intern.php');
        exit;
    }

    if (isset($_POST['update'])) {
        $id = $_POST['termin_id'];
        $start_date = $_POST['start_date'];
        $start_time = $_POST['start_time'];
        $end_date = $_POST['end_date'];
        $end_time = $_POST['end_time'];

        $start_datetime = $start_date . ' ' . $start_time . ':00';
        $end_datetime = $end_date . ' ' . $end_time . ':00';

        $sql = "UPDATE Mitarbeiterbuchungen SET Terminbeginn = ?, Terminende = ? WHERE MitarbeiterbuchungsID = ?";
        $params = array($start_datetime, $end_datetime, $id);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        header('Location: mitarbeiterbuchung_intern.php');
        exit;
    }

}
?>