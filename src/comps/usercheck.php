<?php
// Das Script prüft, ob der User eingeloggt ist, wenn nicht, gibt er eine Fehlermeldung
if (!isset($_SESSION['UserID'])) {
    echo "<div style='text-align: center; margin-top: 50px;'>";
    echo "<h2>Sie müssen als User eingeloggt sein, um diese Seite zu sehen.</h2>";
    echo "<p><a href='login.php' style='color: blue; text-decoration: underline;'>Anmelden</a></p>";
    echo "</div>";
    die();
}
?>