<?php
// Admin check Script aufrufen
include '../../comps/admincheck.php';
// Datenbankverbindung herstellen
include '../../database/connection.php';

// Freischalten-Logik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['freischalten'])) {
    $bildID = $_POST['bild_id'];
    $adminID = $_SESSION['AdminID'];

    $sql = "UPDATE Bild SET Freigabestatus = 1, AdminID = ? WHERE BildID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $adminID, $bildID);
    $stmt->execute();
}

// Bilder anzeigen und Bewertungsformular bereitstellen
$sql = "SELECT b.BildID, b.Titel, b.Bilddatei, k.EMail 
        FROM Bild b 
        JOIN kunde k ON b.KundenID = k.KundenID 
        WHERE b.Freigabestatus = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='" . $row['Bilddatei'] . "' alt='" . $row['Titel'] . "' width='200'><br>";
        echo "<strong>" . $row['Titel'] . "</strong><br>";
        echo "<strong>" . $row['EMail'] . "</strong><br>";
        // Implementierung der Javascript funktion confirmFreischalten
        echo "<form action='' method='POST' onsubmit='return confirmFreischalten()'>";
        echo "<input type='hidden' name='bild_id' value='" . $row['BildID'] . "'>";
        echo "<button type='submit' name='freischalten'>Freischalten</button>";
        echo "</form>";
        echo "</div><hr>";
    }
} else {
    echo "Keine Bilder vorhanden.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contest Admin</title>
    <script>
        // SImple Confirm script um missclicks auszuschliessen
        function confirmFreischalten() {
            return confirm("Sind Sie sicher, dass Sie dieses Bild freischalten möchten?");
        }
    </script>
</head>
<body>
</body>
</html>