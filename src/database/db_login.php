<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailKunde = $_POST['EMail'];
    $passwordKunde = $_POST['Password'];


    $getStateQuery = "SELECT Status FROM kunde WHERE EMail = ?";
    $stmt = $conn->prepare($getStateQuery);
    $stmt->bind_param("s", $emailKunde);
    $stmt->execute();
    $result = $stmt->get_result();
    $stateResult = $result->fetch_assoc();

    if ($stateResult) {
        if ($stateResult['Status'] === 'gelöscht') {
            // Ausgabe falls email schon existiert ABER status 'gelöscht' ist
            echo "<script>alert('Es wurde kein Konto mit dieser E-Mail-Adresse gefunden. Bitte registrieren Sie sich.');</script>";
            echo "<script>window.location.href = './register.php';</script>";

            // die("Es wurde kein Konto mit dieser E-Mail-Adresse gefunden. Bitte registrieren Sie sich.");
        } else if ($stateResult['Status'] === 'aktiv') {
            // Benutzung von Prepared Statements um SQL Injections zu verhindern
            $prst = $conn->prepare("SELECT KundenID, Password_Hash FROM kunde WHERE EMail = ?");
            // Der Platzhalter ? wird durch den string Wert "s" im emailKunde ersetzt
            $prst->bind_param("s", $emailKunde);
            // Ausführen des Prepared Statements
            $prst->execute();
            // Ergebnis speichern
            $prst->store_result();

            if ($prst->num_rows > 0) {
                $prst->bind_result($kundeID, $hashedPassword);
                $prst->fetch();

                if (password_verify($passwordKunde, $hashedPassword)) {
                    echo "<p class='success'>Login erfolgreich!</p>";
                    $_SESSION['UserID'] = $kundeID;
                    echo "<script>window.location.href = './menus.php';</script>";
                } else {
                    echo "<p class='error'>Ungültiges Passwort. Bitte versuchen Sie es erneut.</p>";
                }
            } else {
                echo "<p class='error'>Kein Konto mit dieser E-Mail gefunden. Bitte registrieren Sie sich zuerst.</p>";
            }

            $prst->close();
            $conn->close();
        }
    }
}
