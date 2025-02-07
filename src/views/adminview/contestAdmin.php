<?php
// Admin check Script aufrufen
include '../../comps/admincheck.php';
// Datenbankverbindung herstellen
include '../../database/connection.php';

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
        echo "<form action='' method='POST'>";
        echo "<input type='hidden' name='bild_id' value='" . $row['BildID'] . "'>";
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