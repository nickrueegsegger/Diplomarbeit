<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <div class="container">
        <h2>Anmelden</h2>
        <form action="check_login.php" method="post">
            <label for="benutzername">Benutzername:</label>
            <input type="text" name="benutzername" required>

            <label for="passwort">Passwort:</label>
            <input type="password" name="passwort" required>

            <button type="submit">Anmelden</button>
        </form>
    </div>

    <div class="container">
        <h2>Mitarbeiterlogin erstellen</h2>
        <form action="check_password.php" method="post">
            <label for="admin_password">Admin-Passwort eingeben:</label>
            <input type="password" id="admin_password" name="admin_password">
            <input type="submit" value="Bestätigen">
        </form>
    </div>
</body>

</html>