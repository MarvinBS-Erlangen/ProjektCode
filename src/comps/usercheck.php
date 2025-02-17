<?php
// Das Script prüft, ob der User eingeloggt ist wenn nicht gibt er eine Fehlermeldung
if (!isset($_SESSION['UserID'])) {
    die("Sie müssen als User eingeloggt sein, um diese Seite zu sehen. <a href='login.php'>Anmelden</a>");
}
?>