<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Abmeld Logik // Fuer moegliche erweiterung logout spezifisch gennant
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    // Umleitung auf den Login screen
    // Kann noch entfernt werden wenn nötig
    header("Location: loginAdmin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Willkommen im Admin-Dashboard</h1>
    <p>Sie sind erfolgreich eingeloggt.</p>
    
    <ul>
        <li><a href="contestAdmin.php">Contest Freischalten</a></li>
        <li><a href="produktAdmin.php">Produkte Bearbeiten</a></li>
        <li><a href="ZutatAdmin.php">Zutat Admin</a></li>
        <li><a href="ProduktZutatAdmin.php">Produkt_Zutat</a></li>
        <li><a href="bestellungAdmin.php">Bestellungen</a></li>
        <li><a href="adminDashboard.php?action=logout">Abmelden</a></li>
    </ul>
</body>
</html>