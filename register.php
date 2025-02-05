<?php
session_start();
//Verbindung zur Datenbank herstellen 
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vornameKunde = $_POST['Vorname'];
    $nachnameKunde = $_POST['Nachname'];
    $emailKunde = $_POST['EMail'];
    $passwordKunde = password_hash($_POST['Password_Hash'], PASSWORD_DEFAULT);

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
        } else {
            echo "<p class='error'>Error: " . $prst->error . "</p>";
        }
    }

    $prst->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
</head>
<body>
    <h2>Registrieren</h2>
    <form action="register.php" method="post">
        <label for="vorname">Vorname:</label>
        <input type="text" id="vorname" name="Vorname" required><br><br>
        
        <label for="nachname">Nachname:</label>
        <input type="text" id="nachname" name="Nachname" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="EMail" required><br><br>
        
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="Password_Hash" required><br><br>
        
        <label for="agb">Ich stimme den <a href="agb.html" target="_blank">AGB</a> zu:</label>
        <input type="checkbox" id="agb" name="AGB" required><br><br>
        
        <input type="submit" value="Registrieren">
    </form>
</body>
</html>