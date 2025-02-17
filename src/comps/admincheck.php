<?php
// Das Script prüft, ob der Admin eingeloggt ist wenn nicht gibt er eine Fehlermeldung
if (!isset($_SESSION['AdminID'])) {
    die("Sie müssen als Admin eingeloggt sein, um diese Seite zu sehen. <a href='loginAdmin.php'>Anmelden</a>");
}
?>