<?php
// Verbindung zur Datenbank herstellen
include 'connection.php';

try {
    //erstelle eines PDO Objectes fuer den zugriff auf die Datenbank
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    //setyzen des Fehlermodus auf Ausnahme
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung fehlgeschlagen: " . $e->getMessage());
}

// Verarbeitung des Post requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produktname = $_POST['produktname'] ?? '';
    $beschreibung = $_POST['beschreibung'] ?? '';
    $preis = $_POST['preis'] ?? 0.00;
    $energiewert = $_POST['energiewert'] ?? NULL;
    $bildurl = $_POST['bildurl'] ?? '';

    // Validierung
    if (empty($produktname) || empty($preis) || empty($bildurl)) {
        echo "<p style='color: red;'>Produktname, Preis und Bild URL sind Pflichtfelder.</p>";
    } else {
        // SQL-Befehl zum Einfügen eines Produkts
        $sql = "INSERT INTO produkt (Produktname, Beschreibung, Preis, Energiewert, BildURL) 
                VALUES (:produktname, :beschreibung, :preis, :energiewert, :bildurl)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':produktname' => $produktname,
            ':beschreibung' => $beschreibung,
            ':preis' => $preis,
            ':energiewert' => $energiewert,
            ':bildurl' => $bildurl
        ]);
        echo "<p style='color: green;'>Produkt erfolgreich hinzugefügt.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produkt hinzufügen</title>
</head>
<body>
    <h1>Produkt hinzufügen</h1>
    <form method="POST" action="produktAdmin.php">
        <label for="produktname">Produktname:</label>
        <input type="text" id="produktname" name="produktname" required><br><br>
        
        <label for="beschreibung">Beschreibung:</label>
        <textarea id="beschreibung" name="beschreibung"></textarea><br><br>
        
        <label for="preis">Preis:</label>
        <input type="number" id="preis" name="preis" step="0.01" required><br><br>
        
        <label for="energiewert">Energiewert:</label>
        <input type="number" id="energiewert" name="energiewert"><br><br>
        
        <label for="bildurl">Bild URL:</label>
        <input type="text" id="bildurl" name="bildurl" required><br><br>
        
        <button type="submit">Produkt hinzufügen</button>
    </form>
</body>
</html>