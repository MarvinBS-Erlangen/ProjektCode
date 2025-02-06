<?php
session_start();
// Verbindung zur Datenbank herstelle
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vornameKunde = $_POST['Vorname'];
    $nachnameKunde = $_POST['Nachname'];
    $emailKunde = $_POST['EMail'];
    $passwordKundeUnhashed = $_POST['Password_Hash'];
    $passwordKunde = password_hash($_POST['Password_Hash'], PASSWORD_DEFAULT);
    $confirmPassword = $_POST['Confirm_Password'];

     // Überprüfen, ob die Passwörter übereinstimmen
     if ($passwordKundeUnhashed !== $confirmPassword) {
        echo "<p class='error'>Passwörter not the Uebereinstimming.</p>";
    } else {

    // Benutzungung von prst -> Prepared statement um SQL Injections zu verhindern
    $prst = $conn->prepare("SELECT KundenID FROM kunde WHERE EMail = ?");
    // Der Platzhalter ? wird durch den string wert "s" im emailKunde ersetzt
    $prst->bind_param("s", $emailKunde);
    // ausfuehren des prst
    $prst->execute();
    // Speichern der ergebnisse
    $prst->store_result();

    if ($prst->num_rows > 0) {
        echo "<p class='error'>Email already exists. Please choose another one.</p>";
    } else {
        // Erstellen eines prst um einen neuen Kunden hinzuzufuegen
        $prst = $conn->prepare("INSERT INTO kunde (Vorname, Nachname, EMail, Password_Hash) VALUES (?, ?, ?, ?)");
        // Platzhalter durch werte ersetzen
        $prst->bind_param("ssss", $vornameKunde, $nachnameKunde, $emailKunde, $passwordKunde);

        // schaue ob das prst erfolreich ausgefuehrt wurde
        if ($prst->execute()) {
            echo "<p class='success'>Registration successful!</p>";
            header("Location: login.php");
            exit();
        } else {
            echo "<p class='error'>Error: " . $prst->error . "</p>";
        }
    }

    $prst->close();
    $conn->close();
}
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../public/styles/index.css">
        <title>Registrieren</title>
</head>

<body>

<?php include './partials/header.php'; ?>

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

    <?php include './partials/footer.php'; ?>

</body>

</html>
