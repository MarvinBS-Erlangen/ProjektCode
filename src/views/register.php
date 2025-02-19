<?php
// Datenbank verbindung herstellen
include '../database/connection.php';
// Start der Session
// Sessions initialisieren wenn noch nicht gemacht
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
    <title>Registrierung</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="form-container">
            <h2 class="signup-title">Registrierung</h2>
            <form method="POST" action="../controllers/registerController.php">
                <div class="form-group">
                    <label for="firstname">Vorname</label>
                    <input type="text" id="firstname" name="Vorname" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Nachname</label>
                    <input type="text" id="lastname" name="Nachname" required>
                </div>

                <div class="form-group email-group">
                    <label for="email">E-Mail</label>
                    <input type="email" id="email" name="Email" required>
                </div>

                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="Strasse" required>
                </div>

                <div class="form-group">
                    <label for="house-number">Hausnummer</label>
                    <input type="text" id="house-number" name="Hausnummer" required>
                </div>

                <div class="form-group">
                    <label for="zipcode">PLZ</label>
                    <input type="text" id="zipcode" name="Postleitzahl" required>
                </div>

                <div class="form-group">
                    <label for="city">Stadt</label>
                    <input type="text" id="city" name="Stadt" required>
                </div>

                <div class="form-group">
                    <label for="country">Land</label>
                    <input type="text" id="country" name="Land" required>
                </div>

                <div class="form-group phone-group">
                    <label for="phone">Telefonnummer</label>
                    <input type="text" id="phone" name="Telefon" required>
                </div>

                <div class="form-group">
                    <label for="password">Passwort</label>
                    <input type="password" id="password" name="Passwort" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Passwort bestätigen</label>
                    <input type="password" id="confirm-password" name="Passwort_bestaetigen" required>
                </div>

                <div class="form-group agb-container agb-group">
                    <label for="agb">Ich akzeptiere die <a href="agb.php">AGB:</a></label>
                    <input type="checkbox" id="agb" name="agb" required>
                </div>

                <button type="submit" id="btn-signup">Registrieren</button>
            </form>
            <div class="already-registered">
                <p>Bereits registriert? <a href="./login.php">Hier einloggen</a></p>
            </div>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>
