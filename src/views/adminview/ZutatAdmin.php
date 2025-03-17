<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Verarbeitung des Formulars
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zutatname = $_POST['zutatenname'] ?? '';
    $beschreibung = $_POST['beschreibung'] ?? '';

    
    // SQL-Befehl zum Einfügen einer Zutat
    $sql = "INSERT INTO Zutat (Zutatenname, Beschreibung) VALUES (?, ?)";
    
    $prst = $conn->prepare($sql);
    $prst->bind_param("ss", $zutatname, $beschreibung);
    $prst->execute();
    
    echo "<p style='color: green;'>Zutat erfolgreich hinzugefügt.</p>";
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zutat hinzufügen</title>
</head>
<body>
    <h1>Zutat hinzufügen</h1>
    <form method="POST" action="ZutatAdmin.php">
        <label for="zutatenname">Zutatenname:</label>
        <input type="text" id="zutatenname" name="zutatenname" required><br><br>
        
        <label for="beschreibung">Beschreibung:</label>
        <textarea id="beschreibung" name="beschreibung"></textarea><br><br>
        
        <button type="submit">Zutat hinzufügen</button>
    </form>
</body>
</html>