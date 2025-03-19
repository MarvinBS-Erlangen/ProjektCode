<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_login.php';
?>




<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/login.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/login-handler.js" defer></script>
    <title>Login</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <?php
    // Überprüfen, ob eine Fehlermeldung in der Session vorhanden ist
    if (isset($_SESSION['error_message'])) {
        // Fehlermeldung anzeigen
        echo "<div class='error-banner'>" . $_SESSION['error_message'] . "</div>";
        
        // Fehlermeldung nach der Anzeige aus der Session löschen
        unset($_SESSION['error_message']);
    }
    ?>

    <main>
        <div class="form-container">
            <h2 class="login-title">Login</h2>
            <form action="login.php" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="EMail" required>

                <label for="password">Passwort:</label>
                <input type="password" id="password" name="Password" required>

                <div class="button-container">
                    <input type="submit" id="btn-login" value="Login">
                </div>
            </form>

            <p class="not-registered">Noch kein Konto? <a href="register.php">Registrieren</a></p>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>

<style>
/* Fehlermeldung-Banner */
.error-banner {
    width: 100%;
    background-color: #FF5733; /* Roter Hintergrund für Fehler */
    color: white;
    text-align: center;
    padding: 5px;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    margin-top: 0px;
    
}
.error-banner a {
    color: #721c24; /* Gleiche Farbe wie der Text */
    text-decoration: underline; /* Unterstrichen, damit es wie ein Link aussieht */
}

.error-banner a:hover {
    color: #004085; /* Dunkleres Blau für den Hover-Effekt */
    text-decoration: none; /* Entfernt Unterstreichung beim Hover */
}



</style>
