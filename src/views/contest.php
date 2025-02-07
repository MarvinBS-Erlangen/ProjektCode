<?php
session_start();

// Datenbankverbindung herstellen
include '../database/connection.php';


// Bild hochladen und speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $titel = $_POST['titel'];
    $bildurl = $_POST['bildurl'];

    // Validierung der Bild-URL
    if (filter_var($bildurl, FILTER_VALIDATE_URL)) {
        $sql = "INSERT INTO Bild (Bilddatei, Titel) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $bildurl, $titel);
        $stmt->execute();

        echo "Bild erfolgreich hochgeladen.";
    } else {
        echo "Fehler: Bitte geben Sie eine gültige Bild-URL ein.";
    }
}

// Bewertung speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bewerten'])) {
    $bildID = $_POST['bild_id'];
    $bewertungspunkte = (int)$_POST['bewertungspunkte'];

    $sql = "INSERT INTO Bewertung (BildID, Bewertungspunkte) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bildID, $bewertungspunkte);
    $stmt->execute();

    echo "Bewertung erfolgreich gespeichert.";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bild hochladen und bewerten</title>
</head>
<body>
<h1>Bild hochladen</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <label for="titel">Titel:</label>
    <input type="text" name="titel" id="titel" required><br>

    <label for="bildurl">Bild-URL:</label>
    <input type="url" name="bildurl" id="bildurl" required><br>

    <button type="submit" name="upload">Bild hochladen</button>
</form>

<h1>Bestehende Bilder bewerten</h1>
<?php
// Bilder anzeigen und Bewertungsformular bereitstellen
$sql = "SELECT BildID, Titel, Bilddatei FROM Bild WHERE Freigabestatus = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='" . $row['Bilddatei'] . "' alt='" . $row['Titel'] . "' width='200'><br>";
        echo "<strong>" . $row['Titel'] . "</strong><br>";
        echo "<form action='' method='POST'>";
        echo "<input type='hidden' name='bild_id' value='" . $row['BildID'] . "'>";
        echo "Bewertung (1-5 Sterne): <input type='number' name='bewertungspunkte' min='1' max='5' required><br>";
        echo "<button type='submit' name='bewerten'>Bewerten</button>";
        echo "</form>";
        echo "</div><hr>";
    }
} else {
    echo "Keine Bilder vorhanden.";
}

$conn->close();
?>
</body>
</html>