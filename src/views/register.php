<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_register.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/register.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Registrieren</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main>
        <div class="form-container">
            <h2 class="signup-title">Registrieren</h2>
            <form action="register.php" method="post">
                <label for="vorname">Vorname:</label>
                <input type="text" id="vorname" name="Vorname" required>

                <label for="nachname">Nachname:</label>
                <input type="text" id="nachname" name="Nachname" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="EMail" required>

                <label for="password">Passwort:</label>
                <input type="password" id="password" name="Password_Hash" required>

                <label for="Confirm_Password">Passwort bestätigen:</label>
                <input type="password" id="Confirm_Password" name="Confirm_Password" required>

                <div class="agb-container">
                    <div class="label-container"><label for="agb">Ich stimme den <a href="agb.html" target="_blank">AGB</a> zu:</label></div>
                    <div class="checkbox-container"><input type="checkbox" id="agb" name="AGB" required></div>
                </div>

                <input type="submit" id="btn-signup" value="Registrieren">
            </form>
            <p class="already-registered">Bereits registriert? <a href="login.php">Anmelden</a></p>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>
