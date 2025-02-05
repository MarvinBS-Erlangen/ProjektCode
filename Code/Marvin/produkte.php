<?php
session_start();
// Verbindung zur Datenbank herstellen
include 'connection.php';

// SQL-Abfrage, um alle Produkte aus der Tabelle 'produkt' abzurufen
$sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ausgabe der Produkte in einer HTML-Tabelle
    echo "<table border='1'>
            <tr>
                <th>ProduktID</th>
                <th>Produktname</th>
                <th>Beschreibung</th>
                <th>Preis</th>
                <th>Energiewert</th>
                <th>Bild</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["ProduktID"] . "</td>
                <td>" . $row["Produktname"] . "</td>
                <td>" . $row["Beschreibung"] . "</td>
                <td>" . $row["Preis"] . "</td>
                <td>" . $row["Energiewert"] . "</td>
                <td><img src='" . $row["BildURL"] . "' alt='" . $row["Produktname"] . "' width='100'></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Keine Produkte gefunden.";
}

$conn->close();
?>
