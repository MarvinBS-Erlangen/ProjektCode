<?php
session_start();
include 'connection.php';

echo "<a href='warenkorb.php'>Warenkorb anzeigen</a><br><br>";

$sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ProduktID</th>
                <th>Produktname</th>
                <th>Beschreibung</th>
                <th>Preis</th>
                <th>Energiewert</th>
                <th>Bild</th>
                <th>Aktion</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ProduktID']}</td>
                <td>{$row['Produktname']}</td>
                <td>{$row['Beschreibung']}</td>
                <td>{$row['Preis']}</td>
                <td>{$row['Energiewert']}</td>
                <td><img src='{$row['BildURL']}' alt='{$row['Produktname']}' width='100'></td>
                <td><a href='warenkorb.php?action=add&id={$row['ProduktID']}'>In den Warenkorb</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Keine Produkte gefunden.";
}

$conn->close();
?>