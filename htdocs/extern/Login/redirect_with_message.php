<?php
session_start();
$message = "";

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=anmeldeseite.php" />
    <title>Nachricht</title>
</head>

<body>
    <div style="text-align:center; padding: 50px;">
        <h2>
            <?php echo $message; ?>
        </h2>
        <p>Sie werden in 5 Sekunden weitergeleitet...</p>
    </div>
</body>

</html>