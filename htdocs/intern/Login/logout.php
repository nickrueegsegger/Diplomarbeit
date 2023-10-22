<?php
session_start();
unset($_SESSION['loggedin']);
session_destroy(); //Die Session wird "zerstört", also beendet und man ist ausgeloggt.
echo '<script>
    alert("Erfolgreich ausgeloggt.");
    setTimeout(function() {
        window.location.href = "login.php";
    }, 1000);
</script>';
exit;
?>