<?php
$serverName = "DESKTOP-RJNOVNT\DB_MMKZ";
$connectionOptions = array(
    "Database" => "DB_MMKZ_Langnau",
    "Uid" => "sa",
    "PWD" => "Lotus124"
);

//Verbindung herstellen
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>