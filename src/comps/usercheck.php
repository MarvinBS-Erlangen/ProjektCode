<?php
// Das Script prüft, ob der User eingeloggt ist
if (!isset($_SESSION['UserID'])) {
    // Fehlermeldung in der Session speichern
    $_SESSION['error_message'] = "Sie müssen als User eingeloggt sein, um diese Seite zu sehen.";

    // Weiterleitung zur Login-Seite
    header("Location: login.php");
    exit();
}
?>

