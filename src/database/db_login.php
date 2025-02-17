<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailKunde = $_POST['EMail'];
    $passwordKunde = $_POST['Password'];

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
?>