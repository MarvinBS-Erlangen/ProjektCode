<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vornameKunde = $_POST['Vorname'];
    $nachnameKunde = $_POST['Nachname'];
    $emailKunde = $_POST['EMail'];
    $passwordKundeUnhashed = $_POST['Password_Hash'];
    $passwordKunde = password_hash($_POST['Password_Hash'], PASSWORD_DEFAULT);
    $confirmPassword = $_POST['Confirm_Password'];

    // Überprüfen, ob die Passwörter übereinstimmen
    if ($passwordKundeUnhashed !== $confirmPassword) {
        echo "<p class='error'>Passwörter stimmen nicht überein.</p>";
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