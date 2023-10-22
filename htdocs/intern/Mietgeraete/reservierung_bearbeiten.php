<?php
include 'C:\xampp\htdocs\db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        foreach ($_POST['selected_reservations'] as $id) {
            $sql = "DELETE FROM Vermietung WHERE VermietungsID = ?";
            $params = array($id);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }
        }
        header('Location: mietgeraete_intern.php');
        exit;
    }

    if (isset($_POST['update'])) {
        $id = $_POST['reservierung_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $sql = "UPDATE Vermietung SET Vermietungsbeginn = ?, Vermietungsende = ? WHERE VermietungsID = ?";
        $params = array($start_date, $end_date, $id);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        header('Location: mietgeraete_intern.php');
        exit;
    }
}
?>