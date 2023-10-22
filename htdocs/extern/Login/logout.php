<?php
session_start();
session_unset();
session_destroy();
$_SESSION['logged_out'] = true;
header("Location: anmeldeseite.php");
exit();
?>