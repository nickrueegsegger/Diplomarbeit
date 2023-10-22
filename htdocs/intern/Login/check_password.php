<?php
include 'C:\xampp\htdocs\db_connect.php';

$adminPassword = $_POST['admin_password'];

if ($adminPassword == "Lotus124") {
    // Wenn das passwort korrekt ist, wird das Formular angezeigt, um ein Mitarbeiterlogin zu erstellen
    include 'create_login_form.html';
} else {
    echo '<script>
        alert("Falsches Passwort!");
        setTimeout(function() {
            window.location.href = "login.php";
        }, 1000);
    </script>';
}
?>