<?php
// Admin check Script aufrufen
include '../../comps/admincheck.php';
// Verbindung zur Datenbank herstellen
include '../../database/connection.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

// Verarbeitung des Formulars
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zutatname = $_POST['zutatenname'] ?? '';
    $beschreibung = $_POST['beschreibung'] ?? '';

    // Validierung
    if (empty($zutatname)) {
        echo "<p style='color: red;'>Zutatname ist ein Pflichtfeld.</p>";
    } else {
        // SQL-Befehl zum Einfügen einer Zutat
        $sql = "INSERT INTO Zutat (Zutatenname, Beschreibung) VALUES (:zutatenname, :beschreibung)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':zutatenname' => $zutatname,
            ':beschreibung' => $beschreibung
        ]);
        
        echo "<p style='color: green;'>Zutat erfolgreich hinzugefügt.</p>";
    }
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